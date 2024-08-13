<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Persistence\Models\Employee;

readonly class EmployeePersonalInfoPresenter
{

    public function __construct(
        private Employee $employee
    ) {
    }

    public function present(): object
    {
        return (object)[
            'employeeId' => $this->employee->employee_id,
            'currentPosition' => $this->employee->position,
            'salary' => $this->employee->preferred_salary,
            'firstName' => $this->employee->first_name,
            'lastName' => $this->employee->last_name,
            'aboutEmployee' => $this->employee->about_me,
            'experiences' => $this->employee->experiences,
            'skills' => $this->employee->skills
        ];
    }
}