<?php

namespace Database\Factories\Persistence\Models;

use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
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
        $user = User::factory()->employerRole()->create();

        return [
            'company_name' => fake()->company(),
            'company_description' => fake()->text(),
            'employer_id' => Uuid::uuid7()->toString(),
            'user_id' => $user->id,
            'contact_email' => $user->email,
            'company_logo' => 'default_logo.png',
        ];
    }

}
