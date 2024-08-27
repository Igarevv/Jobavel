<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\Auth\RegisterDtoInterface;

readonly class RegisterEmployeeDto implements RegisterDtoInterface
{

    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password,
        private string $role
    ) {
    }

    public function asDatabaseFields(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'created_at' => now()
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
