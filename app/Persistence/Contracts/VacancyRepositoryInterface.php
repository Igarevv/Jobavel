<?php

namespace App\Persistence\Contracts;

use App\DTO\Vacancy\VacancyDto;
use App\Persistence\Filters\Manual\FilterInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface VacancyRepositoryInterface
{

    public function createAndSync(Employer $employer, VacancyDto $vacancyDto): void;

    public function getVacancyById(int $id, array $columns = ['*']): Vacancy;

    public function updateWithSkills(Vacancy $vacancy, VacancyDto $newData): void;

    public function getFilteredVacancies(FilterInterface $filter, int $paginatePerPage): LengthAwarePaginator;

    public function getFilteredVacanciesForEmployer(FilterInterface $filter, int $employerId): LengthAwarePaginator;

    public function searchFullText(string $searchable, int $paginatePerPage): LengthAwarePaginator;

    public function getLatestPublished(int $number): Collection;
}
