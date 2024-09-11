<?php

namespace App\Persistence\Searcher\Searchers;

use App\Enums\Admin\AdminVacanciesSearchEnum;
use App\Persistence\Searcher\BaseSearcher;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Database\Eloquent\Builder;

class VacancySearcher extends BaseSearcher
{

    public function apply(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->when(
            value: $searchDto->getSearchByEnum() === AdminVacanciesSearchEnum::COMPANY,
            callback: fn(Builder $builder) => $this->applySearchingByCompany($builder, $searchDto),
            default: fn(Builder $builder) => $this->applyDefaultSearching($builder, $searchDto)
        );
    }

    protected function applySearchingByCompany(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->join('employers', 'employers.id', '=', 'vacancies.employer_id')
            ->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
                '%'.$searchDto->getSearchable().'%'
            ]);
    }

    protected function applyDefaultSearching(Builder $builder, SearchDtoInterface $searchDto): Builder
    {
        return $builder->whereRaw("LOWER({$searchDto->getSearchByEnum()->toDbField()}) LIKE ?", [
            '%'.$searchDto->getSearchable().'%'
        ]);
    }
}
