<?php

declare(strict_types=1);

namespace App\DTO;

use App\Http\Requests\CreateVacancyRequest;
use Carbon\Carbon;

readonly class VacancyDto
{

    public function __construct(
        public string $title,
        public string $description,
        public array $responsibilities,
        public array $requirements,
        public array $skillSet,
        public string $location,
        public array $offers = [],
        public int $salary = 0,
        public ?Carbon $createdAt = null,
        public ?int $id = null,
        public ?int $responses = 0
    ) {
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
            location: $input['location'],
            offers: $input['offers'] ?? [],
            salary: (int) ($input['salary'] ?? 0)
        );
    }

}
