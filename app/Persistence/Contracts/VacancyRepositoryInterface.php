<?php

namespace App\Persistence\Contracts;

use App\DTO\VacancyDto;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;

interface VacancyRepositoryInterface
{

    public function createAndSync(Employer $employer, VacancyDto $vacancyDto): void;

    public function getVacancyById(int $id): ?Vacancy;

}
