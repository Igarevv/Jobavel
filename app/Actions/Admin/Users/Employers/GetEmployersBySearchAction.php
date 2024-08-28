<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Employers;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Admin\AdminEmployersSearchEnum as Enum;
use App\Persistence\Models\Employer;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class GetEmployersBySearchAction
{
    public function __construct(
        private GetEmployersPaginatedAction $employersPaginatedAction
    ) {
    }

    public function handle(AdminSearchDto $searchDto): Paginator
    {
        if (Str::of($searchDto->getSearchable())->trim()->value() === '') {
            return $this->employersPaginatedAction->handle();
        }

        return $this->prepareData($this->fetchEmployers($searchDto));
    }

    private function applyDefaultSearch(Builder $builder, AdminSearchDto $searchDto): Builder
    {
        return $builder->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
            '%'.Str::lower($searchDto->getSearchable()).'%'
        ]);
    }

    private function applySearchByAccountEmail(Builder $builder, AdminSearchDto $searchDto): Builder
    {
        return $builder->whereHas('user', function (Builder $builder) use ($searchDto) {
            $builder->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
                '%'.$searchDto->getSearchable().'%'
            ]);
        });
    }

    private function fetchEmployers(AdminSearchDto $searchDto): Paginator
    {
        return Employer::query()
            ->with('user:id,email')
            ->when(
                value: $searchDto->getSearchByEnum()->toDbField() === Enum::tryFrom(
                    Enum::ACCOUNT_EMAIL->value
                )?->toDbField(),
                callback: fn(Builder $builder) => $this->applySearchByAccountEmail($builder, $searchDto),
                default: fn(Builder $builder) => $this->applyDefaultSearch($builder, $searchDto)
            )
            ->simplePaginate(10, [
                'user_id',
                'employer_id',
                'company_name',
                'contact_email',
                'company_type',
                'created_at'
            ]);
    }

    private function prepareData(Paginator $employers): Paginator
    {
        return $employers->through(function (Employer $employer) {
            return (object)[
                'id' => Str::mask($employer->employer_id, '*', 5, -2),
                'company' => $employer->company_name,
                'companyType' => $employer->company_type,
                'contactEmail' => $employer->contact_email,
                'accountEmail' => $employer->user->email,
                'createdAt' => $employer->created_at->format('Y-m-d H:i').' '.
                    $employer->created_at->getTimezone(),
            ];
        });
    }
}