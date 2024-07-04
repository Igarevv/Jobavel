<?php

declare(strict_types=1);

namespace App\DTO;

readonly class VacancyDto
{

    private int $employerId;

    public function __construct(
        public string $title,
        public string $description,
        public array $responsibilities,
        public array $requirements,
        public array $skillSet,
        public array $offers = [],
        public int $salary = 0,
    ) {}

    public function linkEmployerToVacancy(int $employer_id): void
    {
        $this->employerId = $employer_id;
    }

    public function getEmployer(): int
    {
        return $this->employerId;
    }

}
