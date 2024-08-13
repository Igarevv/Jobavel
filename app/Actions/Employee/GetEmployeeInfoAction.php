<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Http\Presenters\EmployeePersonalInfoPresenter;
use App\Persistence\Models\Employee;

class GetEmployeeInfoAction
{

    public function handle(string|Employee $employee): object
    {
        if (is_string($employee)) {
            $employee = Employee::findByUuid($employee, [
                'employee_id',
                'position',
                'first_name',
                'last_name',
                'about_me',
                'preferred_salary',
                'experiences',
                'skills'
            ]);
        }

        return (new EmployeePersonalInfoPresenter($employee))->present();
    }

}