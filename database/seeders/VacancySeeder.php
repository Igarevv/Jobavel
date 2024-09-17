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
            Vacancy::factory(5)->create([
                'employer_id' => $employer->id
            ]);
        }

        $vacancies = Vacancy::all();

        foreach ($vacancies as $vacancy) {
            $randomTechSkills = TechSkill::inRandomOrder()->take(5)->get();
            $vacancy->techSkills()->sync($randomTechSkills);
            $vacancy->update(['slug' => Str::lower(Str::slug($vacancy->title).'-'.$vacancy->id)]);
        }
    }
}
