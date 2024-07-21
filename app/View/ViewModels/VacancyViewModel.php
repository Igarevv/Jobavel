<?php

declare(strict_types=1);

namespace App\View\ViewModels;

use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use App\Service\Employer\Storage\EmployerLogoService;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VacancyViewModel
{
    public function __construct(
        private Cache $cache,
        private VacancyRepositoryInterface $vacancyRepository,
        private EmployerLogoService $storageService
    ) {
    }

    public function vacancy(int $vacancy): Vacancy
    {
        $cacheKey = $this->cache->getCacheKey('vacancy', $vacancy);

        return $this->cache->repository()->remember($cacheKey, CarbonInterval::month()->totalSeconds,
            function () use ($vacancy) {
                return $this->vacancyRepository->getVacancyById($vacancy);
            });
    }

    public function vacancyEmployerData(Vacancy $vacancy, ?string $employerId): object
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

    public function publishedVacancies(string $employerId): LengthAwarePaginator
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