<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Persistence\Models\Employee;
use App\Persistence\Models\Vacancy;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAppliedVacanciesAction
{
    public function handle(string $employeeId): LengthAwarePaginator
    {
        $vacancies = Employee::findByUuid($employeeId, ['id'])
            ->vacancies()
            ->with('employer:id,company_name')
            ->paginate(5, ['employer_id', 'title', 'applied_at', 'has_cv', 'slug', 'employee_contact_email']);

        return $vacancies->through(function (Vacancy $vacancy) {
            return (object)[
                'title' => $vacancy->title,
                'company' => $vacancy->employer->company_name,
                'appliedAt' => $vacancy->applied_at,
                'cvFile' => $vacancy->has_cv,
                'slug' => $vacancy->slug,
                'contactEmail' => $vacancy->employee_contact_email
            ];
        });
    }
}