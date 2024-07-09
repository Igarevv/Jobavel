<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\DTO\VacancyDto;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Carbon\Carbon;
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
            'created_at' => Carbon::now(),
        ]);

        DB::transaction(function () use ($employer, $vacancyDto, $vacancy) {
            $vacancy = $employer->vacancy()->save($vacancy);

            if ($vacancy) {
                $vacancy->techSkill()->sync($vacancyDto->skillSet);
            }
        });
    }

}
