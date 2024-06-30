<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //DB::table('users')->truncate(); // optional

        $this->call([
            EmployeeSeeder::class,
            EmployerSeeder::class,
        ]);

        $this->call([
            TechSkillsSeeder::class,
        ]);
    }

}
