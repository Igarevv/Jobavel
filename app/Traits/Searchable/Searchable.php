<?php

declare(strict_types=1);

namespace App\Traits\Searchable;

use App\Persistence\Searcher\BaseSearcher;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function search(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $this->makeSearcher()->search($builder, $searchDto);
    }


    private function makeSearcher(): BaseSearcher
    {
        return app()->make($this->searcher());
    }

    /**
     * Must return searcher class name for current model
     *
     * @return string
     */
    abstract protected function searcher(): string;
}