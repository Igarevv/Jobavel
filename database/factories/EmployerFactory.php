<?php

namespace Database\Factories\Persistence\Models;

use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Persistence\Models\Employer>
 */
class EmployerFactory extends Factory
{

    protected $model = Employer::class;

    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company(),
            'company_description' => $this->faker->text(),
            'employer_id' => Uuid::uuid7()->toString(),
            'company_logo' => 'default_logo.png',
        ];
    }

}
