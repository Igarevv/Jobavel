<?php

namespace Tests\Feature;

use App\DTO\Admin\AdminDeleteVacancyDto;
use App\DTO\Admin\AdminRejectVacancyDto;
use App\Enums\Actions\AdminActionEnum;
use App\Enums\Actions\ReasonToDeleteVacancyEnum;
use App\Enums\Actions\ReasonToRejectVacancyEnum;
use App\Enums\Admin\DeleteVacancyTypeEnum;
use App\Enums\Vacancy\VacancyStatusEnum;
use App\Events\VacancyDeletedPermanentlyByAdmin;
use App\Persistence\Models\Admin;
use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use App\Persistence\Models\Vacancy;
use App\Service\Admin\AdminActions\AdminLogActionService;
use App\Service\Admin\AdminActions\AdminVacancyService;
use Database\Seeders\PermissionSeeder;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Mockery;
use Tests\TestCase;

class AdminModerationTest extends TestCase
{

    use RefreshDatabase;

    private Dispatcher $dispatcher;

    private AdminLogActionService $logActionService;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            PermissionSeeder::class,
        ]);

        $this->admin = Admin::factory()->superUser()->create();

        $this->dispatcher = Mockery::mock(Dispatcher::class);
        $this->dispatcher->shouldReceive('dispatch')
            ->with(Mockery::type(VacancyDeletedPermanentlyByAdmin::class));

        $this->logActionService = Mockery::mock(AdminLogActionService::class);
        $this->logActionService->shouldReceive('log');
    }

    public function test_admin_delete_vacancy_to_trash(): void
    {
        $service = new AdminVacancyService($this->logActionService, $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::IN_MODERATION);

        $dto = $this->makeDeleteVacancyDto(
            $vacancy,
            ReasonToDeleteVacancyEnum::DUPLICATE,
            DeleteVacancyTypeEnum::DELETE_TRASH
        );

        $service->delete($dto);

        $vacancy->refresh();

        $this->assertSoftDeleted($vacancy);
    }

    public function test_admin_delete_vacancy_permanently(): void
    {
        $service = new AdminVacancyService($this->logActionService, $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::IN_MODERATION);

        $dto = $this->makeDeleteVacancyDto(
            $vacancy,
            ReasonToDeleteVacancyEnum::DUPLICATE,
            DeleteVacancyTypeEnum::DELETE_PERMANENTLY
        );

        $this->assertDatabaseHas('vacancies', ['id' => $vacancy->id]);

        $service->delete($dto);

        $this->assertDatabaseMissing('vacancies', ['id' => $vacancy->id]);
    }

    public function test_admin_cannot_move_to_trash_already_trashed_vacancy(): void
    {
        $service = new AdminVacancyService($this->logActionService, $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::IN_MODERATION);

        $dto = $this->makeDeleteVacancyDto(
            $vacancy,
            ReasonToDeleteVacancyEnum::DUPLICATE,
            DeleteVacancyTypeEnum::DELETE_TRASH
        );

        $vacancy->delete();

        $this->assertThrows(
            test: fn() => $service->delete($dto),
            expectedClass: InvalidArgumentException::class,
            expectedMessage: 'Cannot move to trash already trashed vacancy'
        );
    }

    public function test_admin_approve_vacancy(): void
    {
        $service = new AdminVacancyService($this->logActionService, $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::IN_MODERATION);

        $service->approve($vacancy);

        $vacancy->refresh();

        $this->assertEquals(VacancyStatusEnum::APPROVED, $vacancy->status);
    }

    public function test_admin_cannot_approve_already_approved_vacancy(): void
    {
        $service = new AdminVacancyService($this->logActionService, $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::APPROVED);

        $this->assertThrows(
            test: fn() => $service->approve($vacancy),
            expectedClass: InvalidArgumentException::class,
            expectedMessage: 'Cannot approve already approved vacancy'
        );
    }

    public function test_moderation_action_is_logged(): void
    {
        $service = new AdminVacancyService(new AdminLogActionService(), $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::IN_MODERATION);

        $dto = $this->makeDeleteVacancyDto(
            $vacancy,
            ReasonToDeleteVacancyEnum::DUPLICATE,
            DeleteVacancyTypeEnum::DELETE_TRASH
        );

        $service->delete($dto);

        $this->assertDatabaseHas('admin_actions', [
            'actionable_type' => get_class($vacancy),
            'actionable_id' => $vacancy->id,
            'action_name' => AdminActionEnum::DELETE_VACANCY_TEMP_ACTION,
        ]);
    }

    public function test_when_vacancy_is_approved_all_previous_logged_actions_will_removed(): void
    {
        $service = new AdminVacancyService(new AdminLogActionService(), $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::IN_MODERATION);

        $dto = $this->makeDeleteVacancyDto(
            $vacancy,
            ReasonToDeleteVacancyEnum::DUPLICATE,
            DeleteVacancyTypeEnum::DELETE_TRASH
        );

        $service->delete($dto); // first action

        // some actions that will return vacancy to moderation check again
        $vacancy->restore();
        $vacancy->status = VacancyStatusEnum::IN_MODERATION;
        $vacancy->save();

        $dto2 = $this->makeDeleteVacancyDto(
            $vacancy,
            ReasonToDeleteVacancyEnum::INACCURATE_INFORMATION,
            DeleteVacancyTypeEnum::DELETE_TRASH
        );

        $service->delete($dto2);

        // some actions that will return vacancy to moderation check again
        $vacancy->restore();
        $vacancy->status = VacancyStatusEnum::IN_MODERATION;
        $vacancy->save();

        $this->assertDatabaseHas('admin_actions', [
            'actionable_type' => get_class($vacancy),
            'actionable_id' => $vacancy->id,
            'action_name' => AdminActionEnum::DELETE_VACANCY_TEMP_ACTION,
        ]);

        $service->approve($vacancy);

        $this->assertDatabaseMissing('admin_actions', [
            'actionable_type' => get_class($vacancy),
            'actionable_id' => $vacancy->id,
            'action_name' => AdminActionEnum::DELETE_VACANCY_TEMP_ACTION,
        ]);
    }

    public function test_admin_can_reject_vacancy(): void
    {
        $service = new AdminVacancyService($this->logActionService, $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::IN_MODERATION);

        $dto = $this->makeRejectVacancyDto(
            $vacancy,
            ReasonToRejectVacancyEnum::CONTENT_MISMATCH,
        );

        $service->reject($dto);

        $vacancy->refresh();

        $this->assertEquals(VacancyStatusEnum::NOT_APPROVED, $vacancy->status);
    }

    public function test_admin_cannot_reject_already_rejected_vacancy(): void
    {
        $service = new AdminVacancyService($this->logActionService, $this->dispatcher);

        $employer = $this->makeAdditionalEmployer();

        $vacancy = $this->generateVacancy($employer, VacancyStatusEnum::NOT_APPROVED);

        $dto = $this->makeRejectVacancyDto(
            $vacancy,
            ReasonToRejectVacancyEnum::CONTENT_MISMATCH
        );

        $this->assertThrows(
            test: fn() => $service->reject($dto),
            expectedClass: InvalidArgumentException::class,
            expectedMessage: 'Cannot reject already rejected vacancy'
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

    protected function makeDeleteVacancyDto(
        Vacancy $vacancy,
        ReasonToDeleteVacancyEnum $reason,
        DeleteVacancyTypeEnum $deleteType
    ): AdminDeleteVacancyDto {
        return new AdminDeleteVacancyDto(
            admin: $this->admin,
            vacancy: $vacancy,
            reasonEnum: $reason,
            adminDeleteVacancyEnum: $deleteType,
            comment: null
        );
    }

    protected function generateVacancy(Employer $employer, VacancyStatusEnum $vacancyStatusEnum): Vacancy
    {
        return Vacancy::factory()->create([
            'status' => $vacancyStatusEnum,
            'employer_id' => $employer->id,
        ]);
    }

    protected function makeRejectVacancyDto(
        Vacancy $vacancy,
        ReasonToRejectVacancyEnum $reason,
    ): AdminRejectVacancyDto {
        return new AdminRejectVacancyDto(
            admin: $this->admin,
            vacancy: $vacancy,
            reasonEnum: $reason,
            comment: null
        );
    }

}
