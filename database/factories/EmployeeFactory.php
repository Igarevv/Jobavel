<?php

namespace Database\Factories\Persistence\Models;

use App\Persistence\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Persistence\Models\Employee>
 */
class EmployeeFactory extends Factory
{

    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'employee_id' => Uuid::uuid7()->toString(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'position' => $this->faker->jobTitle,
            'preferred_salary' => $this->faker->randomElement([5000, 3500, 4000, 2000, 1000]),
            'about_me' => $this->faker->paragraph(5),
            'created_at' => now(),
            'experiences' => [
                Str::random(8) => [
                    'position' => $this->faker->jobTitle,
                    'company' => $this->faker->company,
                    'from' => Carbon::now()->subYears(2)->format('Y-m-d'),
                    'to' => Carbon::now()->format('Y-m-d'),
                    'description' => [
                        $this->faker->text(100),
                        $this->faker->text(100),
                        $this->faker->text(100)
                    ]
                ]
            ]
        ];
    }

}
