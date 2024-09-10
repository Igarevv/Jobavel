<?php

declare(strict_types=1);

namespace App\Persistence\Searcher\Searchers;

use App\Enums\Admin\AdminEmployersSearchEnum;
use App\Persistence\Searcher\BaseSearcher;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

final class EmployerSearcher extends BaseSearcher
{

    public function apply(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->when(
            value: $searchDto->getSearchByEnum() === AdminEmployersSearchEnum::ID,
            callback: fn(Builder $builder) => $this->applySearchByEmployerId($builder, $searchDto),
            default: function (Builder $builder) use ($searchDto) {
                $builder->when(
                    value: $searchDto->getSearchByEnum() === AdminEmployersSearchEnum::ACCOUNT_EMAIL,
                    callback: fn(Builder $builder) => $this->applySearchByAccountEmail($builder, $searchDto),
                    default: fn(Builder $builder) => $this->applyDefaultSearch($builder, $searchDto)
                );
            }
        );
    }

    private function applyDefaultSearch(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
            '%'.Str::lower($searchDto->getSearchable()).'%'
        ]);
    }

    private function applySearchByAccountEmail(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->whereHas('user', function (Builder $builder) use ($searchDto) {
            $builder->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
                '%'.$searchDto->getSearchable().'%'
            ]);
        });
    }

    private function applySearchByEmployerId(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->where($searchDto->getSearchByEnum()->toDbField(), $searchDto->getSearchable());
    }
}
