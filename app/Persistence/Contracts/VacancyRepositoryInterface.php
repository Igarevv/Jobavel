<?php

namespace App\Persistence\Contracts;

use App\DTO\VacancyDto;
use App\Persistence\Models\Employer;

interface VacancyRepositoryInterface
{

    public function createAndSync(Employer $employer, VacancyDto $vacancyDto): void;

}
