<?php

namespace Database\Factories\Persistence\Models;

use App\Persistence\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Persistence\Models\Vacancy>
 */
class VacancyFactory extends Factory
{

    protected $model = Vacancy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Programmer',
            'description' => $this->faker->paragraph,
            'responsibilities' => $this->faker->sentences(5),
            'requirements' => $this->faker->sentences(5),
            'offers' => $this->faker->sentences(4),
            'location' => $this->faker->country.", ".$this->faker->city,
            'created_at' => Carbon::now(),
            'salary' => 2500,
            'is_published' => (bool) $this->faker->numberBetween(0, 1),
        ];
    }

}
