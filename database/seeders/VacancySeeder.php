<?php

namespace Database\Seeders;

use App\Persistence\Models\Employer;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use Illuminate\Database\Seeder;

class VacancySeeder extends Seeder
{
    public function run(): void
    {
        Vacancy::query()->truncate();

        $employers = Employer::all();

        foreach ($employers as $employer) {
            Vacancy::factory(5)->create([
                'employer_id' => $employer->id
            ]);
        }

        $vacancies = Vacancy::all();

        foreach ($vacancies as $vacancy) {
            $randomTechSkills = TechSkill::inRandomOrder()->take(5)->get();
            $vacancy->techSkills()->sync($randomTechSkills);
        }
    }
}
