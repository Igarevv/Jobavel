<?php

declare(strict_types=1);

namespace App\Service\Employer;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use App\Service\Employer\Storage\EmployerLogoService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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

    public function update(VacancyDto $vacancyDto): void
    {
        if (! $vacancyDto->getVacancyId()) {
            throw new \InvalidArgumentException('Vacancy id not provided');
        }

        $this->vacancyRepository->updateWithSkills($vacancyDto);
    }

    public function getSkillCategories(): Collection
    {
        $cacheKey = $this->cache->getCacheKey('skills');

        return $this->cache->repository()->remember($cacheKey, $this->cache->secondsInYear(), function () {
            $categories = TechSkill::query()->orderBy('skill_name')
                ->toBase()
                ->get();

            $result = [];

            foreach ($categories as $category) {
                $firstLetter = Str::upper(Str::substr($category->skill_name, 0, 1));

                $skill = new \stdClass();
                $skill->id = $category->id;
                $skill->skillName = $category->skill_name;

                if (! Arr::exists($result, $firstLetter)) {
                    $result[$firstLetter] = [];
                }
                $result[$firstLetter][] = $skill;
            }

            return collect($result)->chunk(ceil(count($result) / 3));
        });
    }

    public function getVacancy(int $vacancy): Vacancy
    {
        $cacheKey = $this->cache->getCacheKey('vacancy', $vacancy);

        return $this->cache->repository()->remember($cacheKey, $this->cache->secondsInMonth(),
            function () use ($vacancy) {
                return $this->vacancyRepository->getVacancyById($vacancy);
            });
    }

    public function getEmployerRelatedToVacancy(Vacancy $vacancy, string $employerId): object
    {
        $cacheKey = $this->cache->getCacheKey('vacancy-employer', $employerId);

        return $this->cache->repository()->remember($cacheKey, $this->cache->secondsInMonth(),
            function () use ($vacancy) {
                $employer = $vacancy->employer;

                $companyLogoUrl = $this->storageService->getImageUrlByImageId($employer->company_logo);

                return (object) [
                    'company' => $employer->company_name,
                    'description' => $employer->company_description,
                    'logo' => $companyLogoUrl,
                    'email' => $employer->contact_email
                ];
            });
    }

}
