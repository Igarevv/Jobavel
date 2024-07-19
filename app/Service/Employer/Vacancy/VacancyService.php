<?php

declare(strict_types=1);

namespace App\Service\Employer\Vacancy;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use App\Service\Employer\Storage\EmployerLogoService;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VacancyService
{

    public function __construct(
        protected VacancyRepositoryInterface $vacancyRepository,
        protected EmployerLogoService $storageService,
        protected Cache $cache
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

    public function getVacancy(int $vacancy): Vacancy
    {
        $cacheKey = $this->cache->getCacheKey('vacancy', $vacancy);

        return $this->cache->repository()->remember($cacheKey, CarbonInterval::month()->totalSeconds,
            function () use ($vacancy) {
                return $this->vacancyRepository->getVacancyById($vacancy);
            });
    }

    public function getEmployerRelatedToVacancy(Vacancy $vacancy, ?string $employerId): object
    {
        $cacheKey = $this->cache->getCacheKey('vacancy-employer', $employerId ?: $vacancy->employer->employer_id);

        return $this->cache->repository()->remember($cacheKey, CarbonInterval::month()->totalSeconds,
            function () use ($vacancy) {
                $employer = $vacancy->employer;

                $companyLogoUrl = $this->storageService->getImageUrlByImageId($employer->company_logo);

                return (object) [
                    'company' => $employer->company_name,
                    'description' => $employer->company_description,
                    'logo' => $companyLogoUrl,
                    'email' => $employer->contact_email,
                    'type' => $employer->company_type
                ];
            });
    }

    public function getPublishedVacancies(string $employerId): LengthAwarePaginator
    {
        $employer = Employer::findByUuid($employerId, ['id', 'company_logo', 'company_name']);

        $vacancies = $this->vacancyRepository->getAllPublished($employer->id);

        $employer->company_logo = $this->storageService->getImageUrlByImageId($employer->company_logo);

        foreach ($vacancies as $vacancy) {
            $vacancy->employer = $employer;
            $vacancy->skills = $vacancy->techSkillAsBaseArray();
        }

        return $vacancies;
    }

}
