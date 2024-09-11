<?php

namespace App\Persistence\Searcher\Searchers;

use App\Persistence\Searcher\BaseSearcher;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Database\Eloquent\Builder;

class TechSkillSearcher extends BaseSearcher
{

    public function apply(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->whereRaw("LOWER(skill_name) LIKE ?", [
            '%'.$searchDto->getSearchable().'%'
        ]);
    }

}
