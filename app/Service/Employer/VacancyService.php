<?php

declare(strict_types=1);

namespace App\Service\Employer;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VacancyService
{

    public function __construct(
        protected VacancyRepositoryInterface $vacancyRepository
    ) {
    }

    public function create(string|int $employerId, VacancyDto $vacancyDto): void
    {
        $employerId = $this->getGenericIdOfEmployer($employerId);

        $vacancyDto->linkEmployerToVacancy($employerId);

        $this->vacancyRepository->createAndSync($vacancyDto);
    }

    protected function getGenericIdOfEmployer(string $employerUuid): int
    {
        $employer_id = Employer::query()
            ->where('employer_id', $employerUuid)
            ->pluck('id')
            ->first();

        if (!$employer_id) {
            throw new ModelNotFoundException("Employer model with public id: $employerUuid not found");
        }

        return $employer_id;
    }

}
