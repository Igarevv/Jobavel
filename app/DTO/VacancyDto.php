<?php

declare(strict_types=1);

namespace App\DTO;

use App\Http\Requests\CreateVacancyRequest;

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
    ) {
    }

    public function linkEmployerToVacancy(int $employer_id): void
    {
        $this->employerId = $employer_id;
    }

    public function getEmployer(): int
    {
        return $this->employerId;
    }

    public static function fromRequest(CreateVacancyRequest $request): static
    {
        $input = $request->validated();

        return new static(
            title: $input['title'],
            description: $input['description'],
            responsibilities: $input['responsibilities'],
            requirements: $input['requirements'],
            skillSet: $input['skillset'],
            offers: $input['offers'] ?? [],
            salary: (int) ($input['salary'] ?? 0)
        );
    }

}
