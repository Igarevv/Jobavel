<?php

namespace Feature;

use App\Persistence\Models\Employee;
use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use App\Persistence\Models\Vacancy;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\EmployerSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class EmployeePermissionsTest extends TestCase
{
    use RefreshDatabase;

    private Collection $usersAsEmployee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionSeeder::class, EmployeeSeeder::class, EmployerSeeder::class]);

        $this->usersAsEmployee = User::role('employee')->take(2)->get();
    }

    public function test_employee_can_view_only_their_cv(): void
    {
        $resumeOwner = $this->usersAsEmployee->first();
        $stranger = $this->usersAsEmployee[1];

        $responseStrangerWantToAccessOwnerResume = $this->actingAs($stranger)
            ->get(
                route('employee.resume', [
                    'employee' => $resumeOwner->employee->employee_id,
                    'type' => 'manual'
                ])
            );

        $responseOwnerWantToAccessTheirResume = $this->actingAs($resumeOwner)
            ->get(
                route('employee.resume', [
                    'employee' => $resumeOwner->employee->employee_id,
                    'type' => 'manual'
                ])
            );

        $responseStrangerWantToAccessOwnerResume->assertNotFound();
        $responseOwnerWantToAccessTheirResume->assertOk();
    }

    public function test_employee_can_apply_for_vacancy(): void
    {
        $userAsEmployee = $this->usersAsEmployee->first();

        $vacancy = Vacancy::factory()->state([
            'employer_id' => Employer::query()->first()->id
        ])->create();

        $vacancy->update(['slug' => Str::lower(Str::slug($vacancy->title).'-'.$vacancy->id)]);

        $response = $this->actingAs($userAsEmployee)
            ->withSession(['user' => ['emp_id' => $userAsEmployee->employee->employee_id]])
            ->post(route('vacancies.employee.apply', ['vacancy' => $vacancy->slug]), [
                'cvType' => Employee::CV_TYPE_MANUAL,
                'useCurrentEmail' => true
            ]);

        $response->assertRedirect(route('employee.vacancy.applied'));
    }
}
