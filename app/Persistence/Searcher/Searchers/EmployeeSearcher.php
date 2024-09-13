<?php

declare(strict_types=1);

namespace App\Persistence\Searcher\Searchers;

use App\Enums\Admin\AdminEmployeesSearchEnum;
use App\Persistence\Searcher\BaseSearcher;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Database\Eloquent\Builder;

final class EmployeeSearcher extends BaseSearcher
{

    public function apply(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->when(
            value: $searchDto->getSearchBy() === AdminEmployeesSearchEnum::ID,
            callback: fn(Builder $builder) => $this->applySearchByEmployeeId($builder, $searchDto),
            default: function (Builder $builder) use ($searchDto) {
                $builder->when(
                    value: $searchDto->getSearchBy() === AdminEmployeesSearchEnum::NAME,
                    callback: fn(Builder $builder) => $this->applySearchingByFullName($builder, $searchDto),
                    default: fn(Builder $builder) => $this->applyDefaultSearch($builder, $searchDto)
                );
            }
        );
    }

    private function applySearchingByFullName(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->where('first_name', $searchDto->getSearchable())
            ->orWhere('last_name', $searchDto->getSearchable())
            ->orWhereRaw("LOWER(CONCAT(last_name, ' ', first_name)) LIKE ?", [
                '%'.$searchDto->getSearchable().'%'
            ])
            ->orWhereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", [
                '%'.$searchDto->getSearchable().'%'
            ]);
    }

    private function applyDefaultSearch(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->whereRaw("LOWER({$searchDto->getSearchBy()->toDbField()}) LIKE ?", [
            '%'.$searchDto->getSearchable().'%'
        ]);
    }

    private function applySearchByEmployeeId(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->where($searchDto->getSearchBy()->toDbField(), $searchDto->getSearchable());
    }
}
