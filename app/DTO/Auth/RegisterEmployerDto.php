<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\RegisterDtoInterface;
use App\Enums\Role;
use Ramsey\Uuid\Uuid;

readonly class RegisterEmployerDto implements RegisterDtoInterface
{

    public string $role;

    public function __construct(
        public string $companyName,
        public string $email,
        public string $password
    ) {
        $this->role = Role::EMPLOYER->value;
    }

    public function toDatabaseContext(): array
    {
        return [
            'contact_email' => $this->email,
            'company_name' => $this->companyName,
            'employer_id' => Uuid::uuid7()->toString(),
            'company_logo' => config('app.logo'),
        ];
    }

}
