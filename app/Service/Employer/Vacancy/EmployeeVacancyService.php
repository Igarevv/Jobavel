<?php

declare(strict_types=1);

namespace App\Service\Employer\Vacancy;

use App\DTO\Vacancy\AppliedVacancyDto;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Vacancy;
use Illuminate\Support\Facades\DB;

class EmployeeVacancyService
{
    public function applyEmployeeToVacancy(AppliedVacancyDto $appliedVacancyDto): bool
    {
        $isAppliedYet = $appliedVacancyDto->employee
            ->vacancies()
            ->where('vacancy_id', $appliedVacancyDto->vacancy->id)
            ->exists();

        if ($isAppliedYet) {
            return false;
        }

        DB::transaction(function () use ($appliedVacancyDto) {
            $appliedVacancyDto->employee->vacancies()->attach($appliedVacancyDto->vacancy, [
                'applied_at' => now(),
                'has_cv' => $appliedVacancyDto->useCvFile,
                'employee_contact_email' => $appliedVacancyDto->contactEmail
            ]);

            $appliedVacancyDto->vacancy->update([
                'response_number' => $appliedVacancyDto->vacancy->response_number + 1
            ]);
        });

        return true;
    }

    public function withDrawEmployeeFromVacancy(Vacancy $vacancy, Employee $employee): bool
    {
        if ($employee->vacancies()->detach($vacancy) >= 1) {
            if ($vacancy->response_number > 0) {
                $vacancy->update(['response_number' => $vacancy->response_number - 1]);
            }

            return true;
        }

        return false;
    }

    public function updateAttachedDataForVacancy(AppliedVacancyDto $appliedVacancyDto): int
    {
        return $appliedVacancyDto->employee
            ->vacancies()
            ->updateExistingPivot(
                $appliedVacancyDto->vacancy->id,
                [
                    'has_cv' => $appliedVacancyDto->useCvFile,
                    'employee_contact_email' => $appliedVacancyDto->contactEmail
                ]
            );
    }
}
