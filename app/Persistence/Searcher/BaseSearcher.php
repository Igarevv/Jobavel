<?php

declare(strict_types=1);

namespace App\Persistence\Searcher;

use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseSearcher
{
    public function search(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $this->apply($builder, $searchDto);
    }

    abstract public function apply(Builder $builder, SearchDtoInterface $searchDto): Builder;
}