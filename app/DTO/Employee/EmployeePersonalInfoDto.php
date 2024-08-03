<?php

declare(strict_types=1);

namespace App\DTO\Employee;

use App\Contracts\User\UserDtoInterface;
use App\Http\Requests\Employee\EmployeePersonalInfo;

readonly class EmployeePersonalInfoDto implements UserDtoInterface
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

    public static function fromRequest(EmployeePersonalInfo $employeePersonalInfo): static
    {
        $employee = $employeePersonalInfo->validated();

        return new static(
            firstName: $employee['first-name'],
            lastName: $employee['last-name'],
            currentPosition: $employee['position'],
            aboutEmployee: $employee['about-employee'],
            experiences: $employee['experiences'],
            skills: $employee['skills'],
            preferredSalary: $employee['salary']
        );
    }
}