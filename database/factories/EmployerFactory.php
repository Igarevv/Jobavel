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
        $user = User::factory()->state(['role' => User::EMPLOYER])->create();
        $user->assignRole(User::EMPLOYER);

        return [
            'user_id' => $user->id,
            'company_name' => $this->faker->company(),
            'company_description' => $this->faker->text(),
            'employer_id' => Uuid::uuid7()->toString(),
            // by default email is same as registration, but can be changed to another
            'contact_email' => $user->email,
            'company_logo' => 'default_logo.png',
        ];
    }

}
