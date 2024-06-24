<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\RegisterDtoInterface;
use App\Enums\Role;

readonly class RegisterEmployerDto implements RegisterDtoInterface
{

    private string $role;

    public function __construct(
        private string $companyName,
        private string $email,
        private string $password
    ) {
        $this->role = Role::EMPLOYER->value;
    }

    public function asDatabaseFields(): array
    {
        return [
            'contact_email' => $this->email,
            'company_name' => $this->companyName,
            'company_logo' => config('app.logo'),
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
