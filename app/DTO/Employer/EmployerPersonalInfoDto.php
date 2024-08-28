<?php

declare(strict_types=1);

namespace App\DTO\Employer;

use App\Contracts\User\UserDtoInterface;
use App\Http\Requests\Employer\UpdateEmployerRequest;

readonly final class EmployerPersonalInfoDto implements UserDtoInterface
{
    public function __construct(
        public string $contactEmail,
        public string $description,
        public string $companyName
    ) {
    }

    public static function fromRequest(UpdateEmployerRequest $employerRequest): static
    {
        $employer = $employerRequest->validated();

        return new static(
            contactEmail: $employer['email'],
            description: $employer['description'],
            companyName: $employer['name']
        );
    }
}