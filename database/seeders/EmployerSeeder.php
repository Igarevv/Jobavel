<?php

namespace Database\Seeders;

use App\Persistence\Models\Employer;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use Illuminate\Database\Seeder;

class EmployerSeeder extends Seeder
{

    public function run(): void
    {
        Employer::query()->truncate();

        $this->makeVacancies();

        $vacancy = Vacancy::all();

        foreach ($vacancy as $item) {
            $randomTechSkills = TechSkill::inRandomOrder()->limit(5)->get();
            $item->techSkills()->sync($randomTechSkills);
        }
    }

    private function makeVacancies(): void
    {
        $employer1 = Employer::factory()->create();

        $employer2 = Employer::factory()->create();

        Vacancy::query()->insert([
                [
                    'title' => 'Junior Laravel Developer',
                    'description' => 'Join our team as a Junior Laravel Developer and contribute to exciting web development projects. 
                You will work alongside experienced developers to build and maintain Laravel-based applications, ensuring high performance and responsiveness. 
                This role offers an excellent opportunity to learn and grow in a supportive environment.',
                    'responsibilities' => json_encode([
                        'Develop and maintain Laravel applications.',
                        'Implement new features and functionality.',
                        'Optimize application performance.',
                        'Write clean, maintainable code.',
                        'Collaborate with team members on project requirements.'
                    ], JSON_THROW_ON_ERROR),
                    'requirements' => json_encode([
                        'Solid understanding of PHP and Laravel framework.',
                        'Knowledge of MySQL or other relational databases.',
                        'Understanding of front-end technologies (HTML5, CSS3, JavaScript).',
                        'Ability to work in a team environment.',
                        'Good problem-solving skills.',
                        'Strong attention to detail.',
                        'Excellent communication skills.'
                    ], JSON_THROW_ON_ERROR),
                    'offers' => json_encode([
                        'Opportunity for professional growth and career development.',
                        'Competitive salary based on experience.',
                        'Flexible working hours and remote work options.',
                        'Dynamic and supportive work environment.'
                    ], JSON_THROW_ON_ERROR),
                    'location' => 'USA, Los Angeles',
                    'employment_type' => 'remote',
                    'experience_time' => 1,
                    'created_at' => now(),
                    'salary' => fake()->numberBetween(900, 3500),
                    'is_published' => (bool) fake()->numberBetween(0, 1),
                    'employer_id' => $employer2->id
                ], [
                    'title' => 'Junior Python Django Developer',
                    'description' => 'We are seeking a Junior Python Django Developer to join our team. 
                You will work on developing and maintaining Python Django applications, contributing to the full software development lifecycle. 
                This role is ideal for someone passionate about backend development and eager to enhance their skills in Django framework.',
                    'responsibilities' => json_encode([
                        'Develop and maintain Python Django applications.',
                        'Collaborate with cross-functional teams to define, design, and ship new features.',
                        'Troubleshoot and debug applications to optimize performance.',
                        'Write clean, scalable code using Python best practices.',
                        'Integrate user-facing elements with server-side logic.'
                    ], JSON_THROW_ON_ERROR),
                    'requirements' => json_encode([
                        'Proficiency in Python programming language.',
                        'Experience with Django framework and ORM.',
                        'Understanding of database technologies (e.g., PostgreSQL, MySQL).',
                        'Knowledge of HTML, CSS, and JavaScript.',
                        'Strong problem-solving skills and analytical thinking.',
                        'Ability to work effectively in a team environment.',
                        'Excellent verbal and written communication skills.'
                    ], JSON_THROW_ON_ERROR),
                    'offers' => json_encode([
                        'Growth opportunities in a supportive work environment.',
                        'Competitive salary and benefits package.',
                        'Remote work flexibility.',
                        'Exciting projects and learning opportunities.'
                    ], JSON_THROW_ON_ERROR),
                    'employment_type' => 'remote',
                    'experience_time' => 1,
                    'location' => 'USA, New York',
                    'created_at' => now(),
                    'salary' => fake()->numberBetween(900, 3500),
                    'is_published' => (bool) fake()->numberBetween(0, 1),
                    'employer_id' => $employer1->id
                ], [
                    'title' => 'Junior Golang Developer',
                    'description' => 'We are looking for a Junior Golang Developer to join our team and assist in building scalable Go applications. You will work on backend development projects using Go language, contributing to the architecture and implementation of robust and high-performance systems.',
                    'responsibilities' => json_encode([
                        'Design and develop backend services and APIs using Go language.',
                        'Write clean, efficient, and maintainable code.',
                        'Collaborate with team members to define project requirements and timelines.',
                        'Optimize application performance for scalability and reliability.',
                        'Implement unit tests and ensure code quality.'
                    ], JSON_THROW_ON_ERROR),
                    'requirements' => json_encode([
                        'Proficiency in Go programming language.',
                        'Experience with RESTful APIs and microservices architecture.',
                        'Knowledge of relational and NoSQL databases.',
                        'Understanding of concurrency and parallelism in Go.',
                        'Familiarity with version control systems (e.g., Git).',
                        'Ability to work independently and in a team setting.',
                        'Good communication skills and a proactive attitude.'
                    ], JSON_THROW_ON_ERROR),
                    'offers' => json_encode([
                        'Career growth opportunities and skill development.',
                        'Competitive salary based on experience and skills.',
                        'Flexible work arrangements, including remote options.',
                        'Innovative and collaborative work environment.'
                    ], JSON_THROW_ON_ERROR),
                    'location' => 'USA, Las Vegas',
                    'created_at' => now(),
                    'employment_type' => 'remote',
                    'experience_time' => 3,
                    'salary' => fake()->numberBetween(900, 3500),
                    'is_published' => (bool) fake()->numberBetween(0, 1),
                    'employer_id' => $employer1->id
                ], [
                    'title' => 'Senior Java Developer',
                    'description' => 'We are looking for a Junior Java Developer to join our team and assist in building scalable Java applications. You will work on backend development projects using Java language, contributing to the architecture and implementation of robust and high-performance systems.',
                    'responsibilities' => json_encode([
                        'Design and develop backend services and APIs using Java language.',
                        'Write clean, efficient, and maintainable code.',
                        'Collaborate with team members to define project requirements and timelines.',
                        'Optimize application performance for scalability and reliability.',
                        'Implement unit tests and ensure code quality.'
                    ], JSON_THROW_ON_ERROR),
                    'requirements' => json_encode([
                        'Proficiency in Java programming language.',
                        'Experience with RESTful APIs and microservices architecture.',
                        'Knowledge of relational and NoSQL databases.',
                        'Understanding of concurrency and parallelism in Java.',
                        'Experience with Spring Framework',
                        'Familiarity with version control systems (e.g., Git).',
                        'Ability to work independently and in a team setting.',
                        'Good communication skills and a proactive attitude.'
                    ], JSON_THROW_ON_ERROR),
                    'offers' => json_encode([
                        'Career growth opportunities and skill development.',
                        'Competitive salary based on experience and skills.',
                        'Flexible work arrangements, including remote options.',
                        'Innovative and collaborative work environment.'
                    ], JSON_THROW_ON_ERROR),
                    'location' => 'USA, Washington',
                    'created_at' => now(),
                    'employment_type' => 'remote',
                    'experience_time' => 5,
                    'salary' => fake()->numberBetween(900, 3500),
                    'is_published' => (bool) fake()->numberBetween(0, 1),
                    'employer_id' => $employer2->id
                ]
            ]
        );
    }
}
