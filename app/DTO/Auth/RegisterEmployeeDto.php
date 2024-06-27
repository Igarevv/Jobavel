<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\RegisterDtoInterface;
use App\Persistence\Models\User;

readonly class RegisterEmployeeDto implements RegisterDtoInterface
{

    private string $role;

    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $password
    ) {
        $this->role = User::EMPLOYEE;
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
