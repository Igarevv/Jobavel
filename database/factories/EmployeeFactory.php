<?php

namespace Database\Factories\Persistence\Models;

use App\Persistence\Models\Employee;
use App\Persistence\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Persistence\Models\Employee>
 */
class EmployeeFactory extends Factory
{

    protected $model = Employee::class;

    public function definition(): array
    {
        $user = User::factory()->state(['role' => User::EMPLOYEE])->create();
        return [
            'user_id' => $user->id,
            'employee_id' => Uuid::uuid7()->toString(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $user->email,
        ];
    }

}
