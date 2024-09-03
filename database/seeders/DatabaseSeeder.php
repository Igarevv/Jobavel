<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->truncate();
        User::factory(5)->unverified()->create();
        User::query()->truncate();

        Artisan::call('admin:super');

        $this->call([
            PermissionSeeder::class,
            TechSkillsSeeder::class,
            EmployeeSeeder::class,
            EmployerSeeder::class,
            VacancySeeder::class
        ]);
    }

}
