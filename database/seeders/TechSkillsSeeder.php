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
            ['skill_name' => 'ASP.NET'],
            ['skill_name' => 'Flutter'],
            ['skill_name' => 'Swift'],
            ['skill_name' => 'WordPress'],
            ['skill_name' => 'Angular'],
            ['skill_name' => 'Vue.js'],
            ['skill_name' => 'Hibernate'],
            ['skill_name' => 'Yii'],
            ['skill_name' => 'Jenkins'],
            ['skill_name' => 'MySQL'],
            ['skill_name' => 'Oracle'],
            ['skill_name' => 'Gitlab'],
            ['skill_name' => 'Nginx'],
            ['skill_name' => 'Linux'],
            ['skill_name' => 'MongoDB'],
            ['skill_name' => 'GraphQL'],
            ['skill_name' => 'Redis'],
            ['skill_name' => 'Typescript'],
            ['skill_name' => 'Jira'],
            ['skill_name' => 'Scrum'],
            ['skill_name' => 'Bootstrap'],
            ['skill_name' => 'HTML'],
            ['skill_name' => 'CSS'],
            ['skill_name' => 'SASS/SCSS'],
            ['skill_name' => 'Kubernetes'],
            ['skill_name' => 'Redux'],
            ['skill_name' => 'Swagger'],
            ['skill_name' => 'RabbitMQ'],
            ['skill_name' => 'SQLite'],
            ['skill_name' => 'Firebase'],
            ['skill_name' => 'Kibana'],
            ['skill_name' => 'Objective-C'],
            ['skill_name' => 'Realm'],
            ['skill_name' => 'React Native'],
            ['skill_name' => 'Arduino'],
            ['skill_name' => 'Elasticsearch'],
            ['skill_name' => 'Unity'],
            ['skill_name' => 'Blender'],
            ['skill_name' => 'Unreal Engine'],
            ['skill_name' => 'PostgreSQL'],
        ]);
    }

}
