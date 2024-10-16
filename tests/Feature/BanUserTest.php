<?php

namespace Tests\Feature;

use App\Contracts\Admin\AdminReasonEnumInterface;
use App\DTO\Admin\AdminBannedUserDto;
use App\Enums\Actions\AdminActionEnum;
use App\Enums\Actions\BanDurationEnum;
use App\Enums\Actions\ReasonToBanEmployeeEnum;
use App\Enums\Actions\ReasonToBanEmployerEnum;
use App\Enums\Vacancy\VacancyStatusEnum;
use App\Events\UserBanned;
use App\Exceptions\AdminException\Ban\UserAlreadyPermanentlyBannedException;
use App\Exceptions\AdminException\Ban\UserHasAlreadyBannedException;
use App\Persistence\Models\Admin;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use App\Persistence\Models\Vacancy;
use App\Service\Admin\AdminActions\AdminBanService;
use App\Service\Admin\AdminActions\AdminLogActionService;
use App\Service\Employer\Vacancy\EmployerVacancyService;
use Carbon\Carbon;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\EmployerSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class BanUserTest extends TestCase
{

    use RefreshDatabase;

    private Dispatcher $dispatcher;

    private Admin $admin;

    private EmployerVacancyService $vacancyService;

    private AdminLogActionService $logActionService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            PermissionSeeder::class,
            EmployeeSeeder::class,
            EmployerSeeder::class,
        ]);

        $this->dispatcher = Mockery::mock(Dispatcher::class);
        $this->dispatcher->shouldReceive('dispatch')
            ->with(Mockery::type(UserBanned::class));

        $this->admin = Admin::factory()->superUser()->create();
        $this->admin->assignRole(Admin::ADMIN);

        $this->vacancyService = Mockery::mock(EmployerVacancyService::class);

        $this->logActionService = Mockery::mock(AdminLogActionService::class);
        $this->logActionService->shouldReceive('log');
    }

    public function test_admin_can_ban_employer(): void
    {
        $employer = Employer::query()->first();

        $dto = $this->makeBanDto($employer, ReasonToBanEmployerEnum::SPAM, BanDurationEnum::MONTH);

        $this->vacancyService->shouldReceive('unpublishAllVacanciesForEmployer')->once();

        $banService = $this->makeBanService($this->logActionService, $this->dispatcher, $this->vacancyService);

        $banService->ban($dto);

        $this->assertDatabaseHas('banned_users', [
            'user_id' => $employer->user->user_id,
        ]);
    }

    public function test_admin_can_ban_employee(): void
    {
        $employee = Employee::query()->latest()->first();

        $dto = $this->makeBanDto(
            $employee,
            ReasonToBanEmployeeEnum::INAPPROPRIATE_CONTENT,
            BanDurationEnum::MONTH
        );

        $banService = $this->makeBanService($this->logActionService, $this->dispatcher, $this->vacancyService);

        $banService->ban($dto);

        $this->assertDatabaseHas('banned_users', [
            'user_id' => $employee->user->user_id,
        ]);
    }

    public function test_cannot_ban_already_banned_user(): void
    {
        $employer = $this->makeAdditionalEmployer();

        $dto = $this->makeBanDto($employer, ReasonToBanEmployerEnum::SPAM, BanDurationEnum::MONTH);
        $this->vacancyService->shouldReceive('unpublishAllVacanciesForEmployer');

        $banService = $this->makeBanService($this->logActionService, $this->dispatcher, $this->vacancyService);

        $banService->ban($dto); // first ban

        $this->assertThrows(
            test: fn() => $banService->ban($dto),
            expectedClass: UserHasAlreadyBannedException::class
        );
    }

    public function test_cannot_ban_user_with_permanent_ban(): void
    {
        $employer = $this->makeAdditionalEmployer();

        $dto = $this->makeBanDto($employer, ReasonToBanEmployerEnum::SPAM, BanDurationEnum::PERMANENT);
        $this->vacancyService->shouldReceive('unpublishAllVacanciesForEmployer');

        $banService = $this->makeBanService($this->logActionService, $this->dispatcher, $this->vacancyService);

        $banService->ban($dto); // permanently ban user

        $this->assertThrows(
            test: fn() => $banService->ban($dto),
            expectedClass: UserAlreadyPermanentlyBannedException::class
        );
    }

    public function test_user_will_be_banned_permanently_after_two_bans(): void
    {
        $employee = Employee::query()->first();

        $dto = $this->makeBanDto(
            $employee,
            ReasonToBanEmployeeEnum::INAPPROPRIATE_CONTENT,
            BanDurationEnum::DAY
        );

        $banService = $this->makeBanService($this->logActionService, $this->dispatcher, $this->vacancyService);

        $banService->ban($dto); // first ban

        // skip time when user is banned to be able to give second ban
        Carbon::setTestNow(now()->addDays(2));

        $banService->ban($dto); // second ban

        Carbon::setTestNow(now()->addDays(4));

        $banService->ban($dto); // third ban - permanently

        $this->assertDatabaseHas('banned_users', [
            'user_id' => $employee->user->user_id,
            'duration' => BanDurationEnum::PERMANENT,
        ]);
    }

    public function test_employer_vacancies_will_be_trashed_when_he_is_banned(): void
    {
        $employer = $this->makeAdditionalEmployer();

        $vacancies = Vacancy::factory(3)->published()->create([
            'employer_id' => $employer->id,
        ]);

        $dto = $this->makeBanDto($employer, ReasonToBanEmployerEnum::SPAM, BanDurationEnum::MONTH);

        $banService = $this->makeBanService($this->logActionService, $this->dispatcher, new EmployerVacancyService());

        $banService->ban($dto);

        $vacancies->each(function (Vacancy $vacancy) {
            $vacancy->refresh();
            $this->assertEquals(VacancyStatusEnum::TRASHED, $vacancy->status);
        });
    }

    public function test_ban_action_will_log_to_action_table(): void
    {
        $employee = $this->makeAdditionalEmployee();

        $dto = $this->makeBanDto(
            $employee,
            ReasonToBanEmployeeEnum::INAPPROPRIATE_CONTENT,
            BanDurationEnum::MONTH
        );

        $banService = $this->makeBanService(new AdminLogActionService(), $this->dispatcher, $this->vacancyService);

        $banService->ban($dto);

        $this->assertDatabaseHas('admin_actions', [
            'actionable_id' => $employee->id,
            'actionable_type' => get_class($employee),
            'action_name' => AdminActionEnum::BAN_USER_ACTION,
        ]);
    }

    public function test_banned_users_cannot_be_logged_in(): void
    {
        $employer = $this->makeAdditionalEmployer();

        $dto = $this->makeBanDto($employer, ReasonToBanEmployerEnum::SPAM, BanDurationEnum::MONTH);
        $this->vacancyService->shouldReceive('unpublishAllVacanciesForEmployer');

        $banService = $this->makeBanService($this->logActionService, $this->dispatcher, $this->vacancyService);

        $responseWhenUserNotBanned = $this->actingAs($employer->user)
            ->get(route('home'));

        $responseWhenUserNotBanned->assertOk();

        $banService->ban($dto);

        $response = $this->actingAs($employer->user)
            ->get(route('home'));

        $response->assertForbidden()->assertSee('Your account has been suspended');
    }

    protected function makeBanDto(
        Model $actionableModel,
        AdminReasonEnumInterface $reason,
        BanDurationEnum $duration
    ): AdminBannedUserDto {
        return new AdminBannedUserDto(
            admin: $this->admin,
            actionableUser: $actionableModel,
            reasonToBanEnum: $reason,
            banDurationEnum: $duration,
            comment: null
        );
    }

    protected function makeAdditionalEmployer(): Employer
    {
        $user = User::factory()->create();

        $employer = Employer::factory()->create([
            'contact_email' => $user->email,
            'user_id' => $user->id,
        ]);

        $user->assignRole(User::EMPLOYER);

        return $employer;
    }

    protected function makeAdditionalEmployee(): Employee
    {
        $user = User::factory()->create();

        $employee = Employee::factory()->create([
            'email' => $user->email,
            'user_id' => $user->id,
        ]);

        $user->assignRole(User::EMPLOYEE);

        return $employee;
    }

    protected function makeBanService(
        AdminLogActionService $logActionService,
        Dispatcher $dispatcher,
        EmployerVacancyService $vacancyService
    ): AdminBanService {
        return new AdminBanService(
            logActionService: $logActionService,
            dispatcher: $dispatcher,
            vacancyService: $vacancyService
        );
    }

}
