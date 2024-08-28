<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Employees;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminEmployeesSearchEnum;
use App\Persistence\Models\Employee;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class GetEmployeesBySearchAction
{
    public function __construct(
        private GetEmployeesPaginatedAction $employeesPaginatedAction
    ) {
    }

    public function handle(AdminSearchDto $searchDto): Paginator
    {
        if (Str::of($searchDto->getSearchable())->trim()->value() === '') {
            return $this->employeesPaginatedAction->handle();
        }

        return $this->prepareData($this->fetchEmployees($searchDto));
    }

    private function applySearchingByFullName(Builder $builder, AdminSearchDto $searchDto): Builder
    {
        return $builder->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", [
            '%'.$searchDto->getSearchable().'%'
        ]);
    }

    private function applyDefaultSearch(Builder $builder, AdminSearchDto $searchDto): Builder
    {
        return $builder->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
            '%'.$searchDto->getSearchable().'%'
        ]);
    }

    private function fetchEmployees(AdminSearchDto $searchDto): Paginator
    {
        return Employee::query()
            ->when(
                value: $searchDto->getSearchByEnum() === AdminEmployeesSearchEnum::NAME,
                callback: fn(Builder $builder) => $this->applySearchingByFullName($builder, $searchDto),
                default: fn(Builder $builder) => $this->applyDefaultSearch($builder, $searchDto)
            )->simplePaginate(10, [
                'employee_id',
                'email',
                'first_name',
                'last_name',
                'created_at',
                'position'
            ]);
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