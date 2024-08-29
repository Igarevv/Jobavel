<?php

declare(strict_types=1);

namespace App\Persistence\Searcher\Searchers;

use App\Enums\Admin\AdminEmployeesSearchEnum;
use App\Persistence\Searcher\BaseSearcher;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Database\Eloquent\Builder;

class EmployeeSearcher extends BaseSearcher
{

    public function apply(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->when(
            value: $searchDto->getSearchByEnum() === AdminEmployeesSearchEnum::ID,
            callback: fn(Builder $builder) => $this->applySearchByEmployeeId($builder, $searchDto),
            default: function (Builder $builder) use ($searchDto) {
                $builder->when(
                    value: $searchDto->getSearchByEnum() === AdminEmployeesSearchEnum::NAME,
                    callback: fn(Builder $builder) => $this->applySearchingByFullName($builder, $searchDto),
                    default: fn(Builder $builder) => $this->applyDefaultSearch($builder, $searchDto)
                );
            }
        );
    }

    // TODO: full name search work bad
    private function applySearchingByFullName(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->whereRaw("LOWER(CONCAT(first_name, ' ', last_name)) LIKE ?", [
            '%'.$searchDto->getSearchable().'%'
        ]);
    }

    private function applyDefaultSearch(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
            '%'.$searchDto->getSearchable().'%'
        ]);
    }

    private function applySearchByEmployeeId(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->where($searchDto->getSearchByEnum()->toDbField(), $searchDto->getSearchable());
    }
}