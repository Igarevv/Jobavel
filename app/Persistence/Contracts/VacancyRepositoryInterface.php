<?php

namespace App\Persistence\Contracts;

use App\DTO\VacancyDto;

interface VacancyRepositoryInterface
{

    public function createAndSync(VacancyDto $vacancyDto): void;

}
