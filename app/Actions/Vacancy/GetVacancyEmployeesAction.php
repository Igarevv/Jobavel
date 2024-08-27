<?php

declare(strict_types=1);

namespace App\Actions\Vacancy;

use App\Persistence\Models\Employee;
use App\Persistence\Models\Vacancy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetVacancyEmployeesAction
{

    public function handle(Vacancy $vacancy): LengthAwarePaginator
    {
        $employees = $vacancy->employees()
            ->paginate(10, [
                'first_name',
                'last_name',
                'employee_contact_email',
                'has_cv',
                'resume_file',
                'applied_at',
                'employees.employee_id'
            ]);

        return $this->prepareData($employees);
    }

    public function prepareData(LengthAwarePaginator $employees): LengthAwarePaginator
    {
        return $employees->through(function (Employee $employee) {
            return (object)[
                'fullName' => $employee->getFullName(),
                'contactEmail' => $employee->employee_contact_email,
                'appliedAt' => $employee->applied_at,
                'employeeId' => $employee->employee_id,
                'cvType' => $employee->has_cv ? 'file' : 'manual'
            ];
        });
    }
}