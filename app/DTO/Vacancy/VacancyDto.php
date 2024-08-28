<?php

declare(strict_types=1);

namespace App\DTO\Vacancy;

use Carbon\Carbon;

final class VacancyDto
{

    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly array $responsibilities,
        public readonly array $requirements,
        public readonly array $skillSet,
        public readonly string $location,
        public readonly int $experienceTime,
        public readonly string $employmentType,
        public readonly bool $considerWithoutExp = false,
        public readonly array $offers = [],
        public readonly int $salary = 0,
        public ?Carbon $createdAt = null,
        private ?int $id = null,
        public ?int $responses = 0
    ) {
    }

    public function connectId(int $vacancyId): void
    {
        $this->id = $vacancyId;
    }

    public function getVacancyId(): ?int
    {
        return $this->id;
    }

}
