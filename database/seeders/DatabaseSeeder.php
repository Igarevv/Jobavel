<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->truncate();

        $this->call([
            PermissionSeeder::class,
            TechSkillsSeeder::class,
            EmployeeSeeder::class,
            EmployerSeeder::class,
            VacancySeeder::class
        ]);
    }

}
