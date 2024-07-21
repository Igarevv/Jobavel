<?php

declare(strict_types=1);

namespace App\Service\Employer\Vacancy;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VacancyService
{

    public function __construct(
        protected VacancyRepositoryInterface $vacancyRepository,
    ) {
    }

    public function create(string|int $employerId, VacancyDto $vacancyDto): void
    {
        $employer = Employer::findByUuid($employerId);

        if (! $employer) {
            throw new ModelNotFoundException('Try to get to create vacancy'.$employerId);
        }

        $this->vacancyRepository->createAndSync($employer, $vacancyDto);
    }

    public function update(Vacancy $vacancy, VacancyDto $vacancyDto): void
    {
        $this->vacancyRepository->updateWithSkills($vacancy, $vacancyDto);
    }

}
