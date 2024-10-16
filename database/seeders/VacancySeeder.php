<?php

namespace Database\Seeders;

use App\Persistence\Models\Employer;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VacancySeeder extends Seeder
{
    public function run(): void
    {
        Vacancy::query()->truncate();

        $employers = Employer::query()->take(3)->get();

        foreach ($employers as $employer) {
            $vacancies = Vacancy::factory(5)->make();

            foreach ($vacancies as $vacancy) {
                $vacancy = $employer->vacancies()->save($vacancy);

                $vacancy->techSkills()->sync(TechSkill::inRandomOrder()->take(5)->get());

                $vacancy->slug = Str::lower(Str::slug($vacancy->title).'-'.$vacancy->id);

                $vacancy->save();
            }
        }
    }
}
