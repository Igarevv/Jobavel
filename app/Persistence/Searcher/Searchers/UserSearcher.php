<?php

declare(strict_types=1);

namespace App\Persistence\Searcher\Searchers;

use App\Enums\Admin\AdminDeletedUserSearchEnum;
use App\Persistence\Searcher\BaseSearcher;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Database\Eloquent\Builder;

final class UserSearcher extends BaseSearcher
{

    public function apply(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->when(
            value: $searchDto->getSearchByEnum() === AdminDeletedUserSearchEnum::ID,
            callback: fn(Builder $builder) => $this->applySearchByUserId($builder, $searchDto),
            default: fn(Builder $builder) => $this->applySearchByDefaultFields($builder, $searchDto)
        );
    }

    private function applySearchByUserId(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->where($searchDto->getSearchByEnum()->toDbField(), $searchDto->getSearchable());
    }

    private function applySearchByDefaultFields(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
            '%'.$searchDto->getSearchable().'%'
        ]);
    }
}
