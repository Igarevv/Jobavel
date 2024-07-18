<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\DTO\VacancyDto;
use App\Exceptions\VacancyUpdateException;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
        return Vacancy::with(['techSkill'])->findOrFail($id, $columns);
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
            ]);

            $vacancy->techSkill()->sync($newData->skillSet);
        } catch (\Throwable $e) {
            throw new VacancyUpdateException($e->getMessage(), $e->getCode());
        }
    }

    public function getAllPublished(int $employerId): LengthAwarePaginator
    {
        return Vacancy::with([
                'techSkill' => function ($query) {
                    $query->select(['id', 'skill_name']);
                },
            ]
        )->published($employerId)->paginate(3, ['title', 'location', 'id', 'salary', 'employer_id']);
    }

}
