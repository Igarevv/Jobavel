<?php

declare(strict_types=1);

namespace App\Service\Employer\Vacancy;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\EmployerAccountRepositoryInterface;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Filters\Manual\FilterInterface;
use App\Persistence\Models\Vacancy;
use App\Service\Employer\Storage\EmployerLogoService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Database\Eloquent\Collection;

class VacancyService
{

    public function __construct(
        protected VacancyRepositoryInterface $vacancyRepository,
        protected EmployerLogoService $employerLogoService,
        protected EmployerAccountRepositoryInterface $employerAccountRepository
    ) {
    }

    public function create(string|int $employerId, VacancyDto $vacancyDto): void
    {
        $employer = $this->employerAccountRepository->getById($employerId);

        $this->vacancyRepository->createAndSync($employer, $vacancyDto);
    }

    public function update(Vacancy $vacancy, VacancyDto $vacancyDto): void
    {
        $this->vacancyRepository->updateWithSkills($vacancy, $vacancyDto);
    }

    public function overrideSkillsAndEmployerLogos(Collection $vacancies): Collection
    {
        $processedEmployerLogo = collect();

        $vacancies->each(function (Vacancy $vacancy) use ($processedEmployerLogo) {
            $vacancy->skills = $vacancy->techSkillsAsArrayOfBase();

            $employerId = $vacancy->employer->id;

            if (! $processedEmployerLogo->has($employerId)) {
                $processedEmployerLogo->put(
                    key: $employerId,
                    value: $this->employerLogoService->getImageUrlByEmployer($vacancy->employer)
                );
            }

            $vacancy->employer->company_logo = $processedEmployerLogo->get($employerId);
        });

        return $vacancies;
    }

    public function publishedFilteredVacanciesForEmployer(FilterInterface $filter, string $employerId): Paginator
    {
        $employer = $this->employerAccountRepository->getById($employerId, ['id', 'company_name', 'company_logo']);

        $vacancies = $this->vacancyRepository->getFilteredVacanciesForEmployer($filter, $employer->id);

        $employer->company_logo = $this->employerLogoService->getImageUrlByEmployer($employer);

        $vacancies->each(function (Vacancy $vacancy) use ($employer) {
            $vacancy->employer = $employer;
            $vacancy->skills = $vacancy->techSkillsAsArrayOfBase();
        });

        return $vacancies;
    }


    public function getRandomEmployersLogoWhoHasVacancy(int $count): array
    {
        $randomEmployersLogo = $this->employerAccountRepository->takeRandomEmployerLogos($count);

        return $this->employerLogoService->fetchEmployerLogoInArray($randomEmployersLogo);
    }

}
