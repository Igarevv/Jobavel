<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechSkillsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tech_skills')->delete();
        DB::table('tech_skills')->insert([
            ['skill_name' => 'PHP'],
            ['skill_name' => 'Laravel'],
            ['skill_name' => 'Git'],
            ['skill_name' => 'Python'],
            ['skill_name' => 'Django'],
            ['skill_name' => 'Flask'],
            ['skill_name' => 'Docker'],
            ['skill_name' => 'Java'],
            ['skill_name' => 'Spring'],
            ['skill_name' => 'Symfony'],
            ['skill_name' => 'Node.js'],
            ['skill_name' => 'JavaScript'],
            ['skill_name' => 'Doctrine'],
            ['skill_name' => 'Golang'],
            ['skill_name' => 'Ruby'],
            ['skill_name' => 'Ruby on Rails'],
            ['skill_name' => 'Kotlin'],
            ['skill_name' => 'Rust'],
            ['skill_name' => 'C++'],
            ['skill_name' => 'C#'],
            ['skill_name' => '.NET'],
            ['skill_name' => 'Flutter'],
            ['skill_name' => 'Swift'],
            ['skill_name' => 'WordPress'],
            ['skill_name' => 'Angular'],
            ['skill_name' => 'Vue.js'],
            ['skill_name' => 'React.js'],
        ]);
    }

}
