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
        $user = User::factory()->employeeRole()->create();
        return [
            'employee_id' => Uuid::uuid7()->toString(),
            'user_id' => $user->id,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => $user->email,
        ];
    }

}
