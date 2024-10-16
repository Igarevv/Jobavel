<?php

namespace Tests\Feature;

use App\Enums\Vacancy\VacancyStatusEnum;
use App\Exceptions\AdminException\Vacancy\VacancyInModerationException;
use App\Exceptions\AppException\VacancyIsNotApprovedException;
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

class EmployersPermissionsTest extends TestCase
{

    use RefreshDatabase;

    private Collection $usersAsEmployer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([PermissionSeeder::class, EmployerSeeder::class]);

        $this->usersAsEmployer = User::query()->get();
    }

    public function test_employer_cannot_view_another_employer_vacancy_when_it_unpublish(): void
    {
        $vacancy = $this->generateVacancy($this->usersAsEmployer->first()->employer);

        $responseFromAnotherEmployer = $this->actingAs($this->usersAsEmployer[1])
            ->get(route('vacancies.show', ['vacancy' => $vacancy->slug]));

        $responseFromVacancyOwnerEmployer = $this->actingAs($this->usersAsEmployer->first())
            ->get(route('vacancies.show', ['vacancy' => $vacancy->slug]));

        $responseFromAnotherEmployer->assertNotFound();
        $responseFromVacancyOwnerEmployer->assertOk();
    }

    public function test_employer_cannot_publish_or_unpublish_someone_else_vacancy(): void
    {
        $vacancy = $this->generateVacancy($this->usersAsEmployer->first()->employer);

        $responseStrangerPublish = $this->actingAs($this->usersAsEmployer[1])
            ->post(route('employer.vacancy.publish', ['vacancy' => $vacancy->slug]));

        $responseStrangerUnpublish = $this->actingAs($this->usersAsEmployer[1])
            ->post(route('employer.vacancy.unpublish', ['vacancy' => $vacancy->slug]));

        $responseStrangerPublish->assertNotFound();
        $responseStrangerUnpublish->assertNotFound();

        $this->actingAs($this->usersAsEmployer->first())
            ->post(route('employer.vacancy.publish', ['vacancy' => $vacancy->slug]));

        $vacancy->refresh();
        $this->assertTrue($vacancy->isPublished());

        $this->actingAs($this->usersAsEmployer->first())
            ->post(route('employer.vacancy.unpublish', ['vacancy' => $vacancy->slug]));

        $vacancy->refresh();
        $this->assertNotTrue($vacancy->isPublished());
    }

    public function test_employer_cannot_delete_someone_else_vacancy(): void
    {
        $vacancy = $this->generateVacancy($this->usersAsEmployer->first()->employer);

        $responseStrangerSoftDelete = $this->actingAs($this->usersAsEmployer[1])
            ->delete(route('employer.vacancy.destroy', ['vacancy' => $vacancy->slug]));

        $responseStrangerForeverDelete = $this->actingAs($this->usersAsEmployer[1])
            ->delete(route('employer.vacancy.delete-forever', ['vacancy' => $vacancy->slug]));

        $responseStrangerSoftDelete->assertNotFound();
        $responseStrangerForeverDelete->assertNotFound();

        $this->actingAs($this->usersAsEmployer->first())
            ->delete(route('employer.vacancy.destroy', ['vacancy' => $vacancy->slug]));

        $this->assertSoftDeleted($vacancy);

        $this->actingAs($this->usersAsEmployer->first())
            ->delete(route('employer.vacancy.delete-forever', ['vacancy' => $vacancy->slug]));

        $this->assertModelMissing($vacancy);
    }

    public function test_employer_cannot_edit_someone_else_vacancy(): void
    {
        $vacancy = $this->generateVacancy($this->usersAsEmployer->first()->employer);

        $responseStrangerEdit = $this->actingAs($this->usersAsEmployer[1])
            ->put(route('employer.vacancy.update', ['vacancy' => $vacancy->slug]));

        $responseOwnerEdit = $this->actingAs($this->usersAsEmployer->first())
            ->put(route('employer.vacancy.update', ['vacancy' => $vacancy->slug]));

        $responseStrangerEdit->assertNotFound();

        $responseOwnerEdit->assertRedirect();
    }

    public function test_employer_cannot_view_edit_another_employer_vacancy_page(): void
    {
        $vacancy = $this->generateVacancy($this->usersAsEmployer->first()->employer);

        $responseStrangerViewEdit = $this->actingAs($this->usersAsEmployer[1])
            ->get(route('employer.vacancy.show.edit', ['vacancy' => $vacancy->slug]));

        $responseOwnerViewEdit = $this->actingAs($this->usersAsEmployer->first())
            ->get(route('employer.vacancy.show.edit', ['vacancy' => $vacancy->slug]));

        $responseStrangerViewEdit->assertNotFound();
        $responseOwnerViewEdit->assertOk();
    }

    public function test_employer_cannot_apply_for_vacancy(): void
    {
        $vacancy = $this->generateVacancy($this->usersAsEmployer->first()->employer);

        $responseEmployerOnApply = $this->actingAs($this->usersAsEmployer->first())
            ->post(route('vacancies.employee.apply', ['vacancy' => $vacancy->slug]));

        $responseEmployerOnApply->assertNotFound();
    }

    public function test_employer_cannot_view_trashed_vacancy_another_employer(): void
    {
        $vacancy = $this->generateVacancy($this->usersAsEmployer->first()->employer);

        // make vacancy trashed
        $vacancy->moveToTrash();

        $responseStrangerViewTrashed = $this->actingAs($this->usersAsEmployer[1])
            ->get(route('employer.vacancy.trashed.preview', ['vacancy' => $vacancy->slug]));

        $responseOwnerViewTrashedPreview = $this->actingAs($this->usersAsEmployer->first())
            ->get(route('employer.vacancy.trashed.preview', ['vacancy' => $vacancy->slug]));

        $responseStrangerViewTrashed->assertNotFound();
        $responseOwnerViewTrashedPreview->assertOk();
    }

    public function test_employer_cannot_view_employee_cv_when_his_not_applied_for_vacancy(): void
    {
        $this->seed(EmployeeSeeder::class);

        $userAsEmployee = User::role('employee')->first();
        $userAsEmployer = $this->usersAsEmployer->first();
        $vacancy = $this->generateVacancy($userAsEmployer->employer);

        $this->actingAs($userAsEmployee)
            ->withSession(['user' => ['emp_id' => $userAsEmployee->employee->employee_id]])
            ->post(route('vacancies.employee.apply', ['vacancy' => $vacancy->slug]), [
                'cvType' => Employee::CV_TYPE_MANUAL,
                'useCurrentEmail' => true,
            ]);

        $responseStrangerEmployerWantsViewEmployeeResume = $this->actingAs($this->usersAsEmployer[1])
            ->get(
                route(
                    'employee.resume',
                    ['employee' => $userAsEmployee->employee->employee_id, 'type' => 'manual']
                )
            );

        $responseVacancyOwnerWantsViewEmployeeResume = $this->actingAs($userAsEmployer)
            ->get(
                route(
                    'employee.resume',
                    ['employee' => $userAsEmployee->employee->employee_id, 'type' => 'manual']
                )
            );

        $responseStrangerEmployerWantsViewEmployeeResume->assertNotFound();
        $responseVacancyOwnerWantsViewEmployeeResume->assertOk();
    }

    public function test_employer_cannot_publish_not_approved_vacancy(): void
    {
        $vacancy = $this->generateVacancy($this->usersAsEmployer->first()->employer);

        $vacancy->status = VacancyStatusEnum::IN_MODERATION;
        $vacancy->save();

        $responseWhenVacancyInModeration = $this->actingAs($this->usersAsEmployer->first())
            ->post(
                route('employer.vacancy.publish', ['vacancy' => $vacancy->slug])
            );

        $responseWhenVacancyInModeration->assertSessionHas(
            'errors-publish',
            (new VacancyInModerationException())->getMessage()
        );

        $vacancy->status = VacancyStatusEnum::NOT_APPROVED;
        $vacancy->save();

        $responseWhenVacancyNotApproved = $this->post(
            route('employer.vacancy.publish', ['vacancy' => $vacancy->slug])
        );

        $responseWhenVacancyNotApproved->assertSessionHas(
            'errors-publish',
            (new VacancyIsNotApprovedException())->getMessage()
        );
    }

    private function generateVacancy(Employer $employer): Vacancy
    {
        $vacancy = Vacancy::factory()->unpublished()->create([
            'employer_id' => $employer->id,
        ]);

        $vacancy->update(['slug' => Str::lower(Str::slug($vacancy->title).'-'.$vacancy->id)]);

        return $vacancy;
    }

}
