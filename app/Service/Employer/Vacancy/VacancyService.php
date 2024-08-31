<?php

declare(strict_types=1);

namespace App\Service\Employer\Vacancy;

use App\DTO\Vacancy\VacancyDto;
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

    public function overrideEmployerLogos(Collection|Paginator $vacancies): Collection|Paginator
    {
        $processedEmployerLogo = collect();

        $vacancies->each(function (Vacancy $vacancy) use ($processedEmployerLogo) {
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
        });

        return $vacancies;
    }

    public function allPublishedFilteredVacancies(FilterInterface $filter, int $paginatePerPage): Paginator
    {
        $vacancies = $this->vacancyRepository->getFilteredVacancies($filter, $paginatePerPage);

        return $this->overrideEmployerLogos($vacancies);
    }

    public function searchVacancies(string $searchable, int $paginatePerPage): Paginator
    {
        return $this->vacancyRepository->searchFullText($searchable, $paginatePerPage);
    }

    public function getRandomEmployersLogoWhoHasVacancy(int $count): array
    {
        $randomEmployersLogo = $this->employerAccountRepository->takeRandomEmployerLogos($count);

        return $this->employerLogoService->fetchEmployerLogoInArray($randomEmployersLogo);
    }

}
