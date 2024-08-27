<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users;

use App\Persistence\Models\Employee;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Str;

class GetEmployeesPaginatedAction
{
    public function handle(): Paginator
    {
        $employees = Employee::query()->simplePaginate(10, [
            'employee_id',
            'email',
            'first_name',
            'last_name',
            'created_at',
            'position'
        ]);

        return $this->prepareData($employees);
    }

    private function prepareData(Paginator $employees): Paginator
    {
        return $employees->through(function (Employee $employee) {
            return (object)[
                'id' => Str::mask($employee->employee_id, '*', 5, -2),
                'email' => $employee->email,
                'name' => $employee->getFullName(),
                'position' => $employee->position ?? 'Not specified',
                'createdAt' => $employee->created_at->format('Y-m-d H:i').' '.
                    $employee->created_at->getTimezone()
            ];
        });
    }
}