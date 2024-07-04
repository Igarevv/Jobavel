<?php

namespace Database\Seeders;

use App\Persistence\Models\Employer;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employer = Employer::factory()->create();

        $vacancy = Vacancy::factory(2)->create([
            'employer_id' => $employer->id,
        ]);

        foreach ($vacancy as $item) {
            $randomTechSkills = TechSkill::inRandomOrder()->limit(5)->get();
            $item->techSkills()->sync($randomTechSkills);
        }
    }

}
