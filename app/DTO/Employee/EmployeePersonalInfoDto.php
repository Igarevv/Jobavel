<?php

declare(strict_types=1);

namespace App\DTO\Employee;

use App\Contracts\User\UserDtoInterface;

readonly final class EmployeePersonalInfoDto implements UserDtoInterface
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $currentPosition,
        public string $aboutEmployee,
        public ?array $experiences = null,
        public ?array $skills = null,
        public int $preferredSalary = 0,
    ) {
    }

}