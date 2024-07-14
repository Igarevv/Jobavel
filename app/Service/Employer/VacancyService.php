<?php

declare(strict_types=1);

namespace App\Service\Employer;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
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

    public function getSkillCategories(): Collection
    {
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

        return collect($result);
    }

    public function getVacancy(Vacancy|int $vacancy): VacancyDto
    {
        if (is_numeric($vacancy)) {
            $vacancy = $this->vacancyRepository->getVacancyById($vacancy);

            if (! $vacancy) {
                throw new ModelNotFoundException('Vacancy not found');
            }

            return VacancyDto::fromDatabase($vacancy);
        }

        return VacancyDto::fromDatabase($vacancy);
    }

    public function getEmployerRelatedToVacancy(Vacancy $vacancy): object
    {
        $companyLogoUrl = $this->storageService->getImageUrlByImageId($vacancy->employer->company_logo);

        return (object) [
            'company' => $vacancy->employer->company_name,
            'description' => $vacancy->employer->company_description,
            'logo' => $companyLogoUrl,
            'email' => $vacancy->employer->contact_email
        ];
    }

}
