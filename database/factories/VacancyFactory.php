<?php

namespace Database\Factories\Persistence\Models;

use App\Enums\Vacancy\EmploymentEnum;
use App\Persistence\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
        $isPublished = $this->faker->boolean();

        if ($isPublished) {
            $publishedAt = now();
        }

        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(10),
            'responsibilities' => $this->faker->sentences(5),
            'requirements' => $this->faker->sentences(5),
            'offers' => $this->faker->sentences(4),
            'location' => $this->faker->country.", ".$this->faker->city,
            'created_at' => Carbon::now(),
            'employment_type' => Arr::random(
                [
                    EmploymentEnum::EMPLOYMENT_MIXED,
                    EmploymentEnum::EMPLOYMENT_REMOTE,
                    EmploymentEnum::EMPLOYMENT_OFFICE,
                    EmploymentEnum::EMPLOYMENT_PART_TIME,
                ]
            ),
            'experience_time' => Arr::random([0, 1, 3, 5, 10]),
            'consider_without_experience' => $this->faker->boolean(),
            'salary' => $this->faker->numberBetween(0, 5000),
            'is_published' => $isPublished,
            'published_at' => $publishedAt ?? null,
        ];
    }

    public function unpublished(): VacancyFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_published' => false,
                'published_at' => null
            ];
        });
    }

    public function published(): VacancyFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_published' => true,
                'published_at' => now()
            ];
        });
    }
}
