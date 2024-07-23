<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\DTO\VacancyDto;
use App\Exceptions\VacancyUpdateException;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Filters\Manual\FilterInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class VacancyRepository implements VacancyRepositoryInterface
{

    public function createAndSync(Employer $employer, VacancyDto $vacancyDto): void
    {
        $vacancy = new Vacancy([
            'title' => $vacancyDto->title,
            'salary' => $vacancyDto->salary,
            'offers' => $vacancyDto->offers,
            'description' => $vacancyDto->description,
            'requirements' => $vacancyDto->requirements,
            'location' => $vacancyDto->location,
            'responsibilities' => $vacancyDto->responsibilities,
            'experience_time' => $vacancyDto->experienceTime,
            'employment_type' => $vacancyDto->employmentType,
            'consider_without_experience' => $vacancyDto->considerWithoutExp
        ]);

        DB::transaction(function () use ($employer, $vacancyDto, $vacancy) {
            $vacancy = $employer->vacancy()->save($vacancy);

            if ($vacancy) {
                $vacancy->techSkill()->sync($vacancyDto->skillSet);
            }
        });
    }

    public function getVacancyById(int $id, array $columns = ['*']): Vacancy
    {
        return Vacancy::with(['techSkill:id,skill_name'])->findOrFail($id, $columns);
    }

    public function updateWithSkills(Vacancy $vacancy, VacancyDto $newData): void
    {
        try {
            $vacancy->update([
                'title' => $newData->title,
                'description' => $newData->description,
                'responsibilities' => $newData->responsibilities,
                'requirements' => $newData->requirements,
                'offers' => $newData->offers,
                'salary' => $newData->salary,
                'location' => $newData->location,
                'experience_time' => $newData->experienceTime,
                'employment_type' => $newData->employmentType
            ]);

            $vacancy->techSkill()->sync($newData->skillSet);
        } catch (\Throwable $e) {
            throw new VacancyUpdateException($e->getMessage(), $e->getCode());
        }
    }

    public function getPublishedFiltered(FilterInterface $filter, int $employerId): LengthAwarePaginator
    {
        return Vacancy::with('techSkill:id,skill_name')
            ->where('employer_id', $employerId)
            ->published()->filter($filter)->paginate(3,
                ['title', 'location', 'id', 'salary', 'employer_id']);
    }

    public function getLatestPublished(int $number): Collection
    {
        return Vacancy::with(['techSkill:id,skill_name', 'employer:id,employer_id,company_name,company_logo'])
            ->published()
            ->latest()
            ->take($number)
            ->get(['id', 'title', 'employer_id', 'location']);
    }

}
