<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Vacancy;

class VacancyRepository implements VacancyRepositoryInterface
{

    public function createAndSync(VacancyDto $vacancyDto): void
    {
        $vacancy = Vacancy::query()->create([
            'employer_id' => $vacancyDto->getEmployer(),
            'title' => $vacancyDto->title,
            'salary' => $vacancyDto->salary,
            'description' => $vacancyDto->description,
            'requirements' => $vacancyDto->requirements,
            'responsibilities' => $vacancyDto->responsibilities,
            'offers' => $vacancyDto->offers,
        ]);

        $vacancy->techSkills()->sync($vacancyDto->skillSet);
    }

}
