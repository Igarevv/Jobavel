<?php

declare(strict_types=1);

namespace App\View\ViewModels;

use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Filters\Manual\FilterInterface;
use App\Persistence\Filters\Pipeline\PipelineFilterInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use App\Service\Employer\Storage\EmployerLogoService;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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

    public function getRandomEmployerLogos(int $count): array
    {
        $employerLogo = Employer::query()->has('vacancy')
            ->inRandomOrder()->take($count)->get(['id', 'company_logo']);

        return $employerLogo->map(function (Employer $employer) {
            return (object) [
                'url' => $this->storageService->getImageUrlByEmployer($employer)
            ];
        })->toArray();
    }

    public function vacancyEmployerData(Vacancy $vacancy): object
    {
        $employer = $vacancy->employer;

        $cacheKey = $this->cache->getCacheKey('vacancy-employer', $employer->employer_id);

        return $this->cache->repository()->remember($cacheKey, CarbonInterval::month()->totalSeconds,
            function () use ($employer) {
                $companyLogoUrl = $this->storageService->getImageUrlByEmployer($employer);

                return (object) [
                    'company' => $employer->company_name,
                    'description' => $employer->company_description,
                    'logo' => $companyLogoUrl,
                    'email' => $employer->contact_email,
                    'type' => $employer->company_type
                ];
            });
    }

    public function publishedManualFilteredVacancies(FilterInterface $filter, string $employerId): LengthAwarePaginator
    {
        $employer = Employer::findByUuid($employerId, ['id', 'company_logo', 'company_name']);

        $vacancies = $this->vacancyRepository->getPublishedFiltered($filter, $employer->id);

        $employer->company_logo = $this->storageService->getImageUrlByImageId($employerId, $employer->company_logo);

        foreach ($vacancies as $vacancy) {
            $vacancy->employer = $employer;
            $vacancy->skills = collect($vacancy->techSkillAsBaseArray());
        }

        return $vacancies;
    }

    public function getLatestPublishedVacancies(int $howMany): Collection
    {
        $vacancies = $this->vacancyRepository->getLatestPublished($howMany);

        $vacancies->each(function (Vacancy $vacancy) {
            $vacancy->skills = collect($vacancy->techSkillAsBaseArray());

            $employer = clone $vacancy->employer;

            $employer->company_logo = $this->storageService->getImageUrlByEmployer($employer);

            $vacancy->employer = $employer;
        });

        return $vacancies;
    }

    public function publishedPipelineFilter(PipelineFilterInterface $filter, string $employerId): LengthAwarePaginator
    {
        $employer = Employer::findByUuid($employerId, ['id', 'company_logo', 'company_name']);

        $vacancies = Vacancy::with('techSkill:id,skill_name')
            ->published()->pipeLineFilter($filter)->paginate(3,
                ['title', 'location', 'id', 'salary', 'employer_id']);

        $employer->company_logo = $this->storageService->getImageUrlByEmployer($employer);

        foreach ($vacancies as $vacancy) {
            $vacancy->employer = $employer;
            $vacancy->skills = $vacancy->techSkillAsBaseArray();
        }

        return $vacancies;
    }

}