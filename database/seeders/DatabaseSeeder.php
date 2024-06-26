<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Employer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Employee::factory()->count(50)->create();

        Employer::factory()->count(50)->create();

        $this->call([
            TechSkillsSeeder::class,
        ]);
    }

}
