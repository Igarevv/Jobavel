<?php

declare(strict_types=1);

namespace App\Http\Presenters;

use App\Persistence\Models\Vacancy;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;

readonly class VacancyCardPresenter
{
    public function __construct(private Collection|Paginator $vacancies)
    {
    }

    public function paginatedCollectionToBase(): Paginator
    {
        $this->vacancies->through(function (Vacancy $vacancy) {
            return (object)$this->mapper($vacancy)->toArray();
        });

        return $this->vacancies;
    }

    public function collectionToBase(): Collection
    {
        return $this->vacancies->map(function (Vacancy $vacancy) {
            return (object)$this->mapper($vacancy)->toArray();
        });
    }

    protected function mapper(Vacancy $vacancy): Vacancy
    {
        $employer = $vacancy->employer;

        $vacancy->skills = $vacancy->techSkillsAsArrayOfBase();

        unset($vacancy->employer, $vacancy->techSkills);

        $vacancy->employer = (object)$employer->toArray();

        return $vacancy;
    }

}