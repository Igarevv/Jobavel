<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\RegisterDtoInterface;
use App\Enums\Role;

readonly class RegisterEmployeeDto implements RegisterDtoInterface
{

    private string $role;

    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password
    ) {
        $this->role = Role::EMPLOYEE->value;
    }

    public function asDatabaseFields(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

}
