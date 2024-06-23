<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\RegisterDtoInterface;
use App\Enums\Role;
use Ramsey\Uuid\Nonstandard\Uuid;

readonly class RegisterEmployeeDto implements RegisterDtoInterface
{

    public string $role;

    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password
    ) {
        $this->role = Role::EMPLOYEE->value;
    }

    public function toDatabaseContext(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'employee_id' => Uuid::uuid7()->toString(),
        ];
    }

}
