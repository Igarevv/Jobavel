<?php

namespace App\Persistence\Contracts;

use App\DTO\VacancyDto;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface VacancyRepositoryInterface
{

    public function createAndSync(Employer $employer, VacancyDto $vacancyDto): void;

    public function getVacancyById(int $id): Vacancy;

    public function updateWithSkills(Vacancy $vacancy, VacancyDto $newData): void;

    public function getAllPublished(int $employerId): LengthAwarePaginator;
}
