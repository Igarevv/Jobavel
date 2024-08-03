<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Http\Presenters\EmployeePersonalInfoPresenter;
use App\Persistence\Models\Employee;

class GetEmployeeHomeAction
{

    public function handle(string $employeeId): object
    {
        $employee = Employee::findByUuid(
            $employeeId,
            [
                'employee_id',
                'position',
                'first_name',
                'last_name',
                'about_me',
                'preferred_salary',
                'experiences',
                'skills'
            ]
        );

        return (new EmployeePersonalInfoPresenter($employee))->present();
    }

}