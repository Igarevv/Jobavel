<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\Auth\RegisterDtoInterface;

readonly final class RegisterEmployerDto implements RegisterDtoInterface
{

    public function __construct(
        private string $companyName,
        private string $email,
        private string $password,
        private string $role,
        private string $companyLogo,
        private string $companyType
    ) {
    }

    public function asDatabaseFields(): array
    {
        return [
            'contact_email' => $this->email,
            'company_name' => $this->companyName,
            'company_logo' => $this->companyLogo,
            'company_type' => $this->companyType,
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
