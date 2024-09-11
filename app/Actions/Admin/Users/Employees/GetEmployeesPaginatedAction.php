<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Employees;

use App\DTO\Admin\AdminSearchDto;
use App\Persistence\Models\Employee;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetEmployeesPaginatedAction
{

    public function handle(
        AdminSearchDto $searchDto,
        SortedValues $sortedValues
    ): LengthAwarePaginator {
        if (Str::of($searchDto->getSearchable())->trim()->value() === '') {
            return $this->prepareData($this->getSortedOnly($sortedValues));
        }

        return $this->prepareData(
            $this->getSearchedSorted($searchDto, $sortedValues)
        );
    }

    private function getSortedOnly(SortedValues $sortedValues
    ): LengthAwarePaginator {
        return Employee::query()
            ->sortBy($sortedValues)
            ->paginate(10, [
                'employee_id',
                'email',
                'first_name',
                'last_name',
                'created_at',
                'position',
            ]);
    }

    private function getSearchedSorted(
        AdminSearchDto $searchDto,
        SortedValues $sortedValues
    ): LengthAwarePaginator {
        return Employee::query()
            ->search($searchDto)
            ->sortBy($sortedValues)
            ->paginate(10, [
                'employee_id',
                'email',
                'first_name',
                'last_name',
                'created_at',
                'position',
            ]);
    }

    private function prepareData(LengthAwarePaginator $employees
    ): LengthAwarePaginator {
        return $employees->through(function (Employee $employee) {
            return (object)[
                'id' => $employee->employee_id,
                'idEncrypted' => Str::mask($employee->employee_id, '*', 5, -2),
                'email' => $employee->email,
                'name' => $employee->getFullName(),
                'position' => $employee->position ?? 'Not specified',
                'createdAt' => $employee->created_at->format('Y-m-d H:i').' '.
                    $employee->created_at->getTimezone(),
            ];
        });
    }

}
