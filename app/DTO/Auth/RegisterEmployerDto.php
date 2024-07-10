<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\Auth\RegisterDtoInterface;
use App\Http\Requests\EmployerRegisterRequest;
use App\Persistence\Models\User;
use Illuminate\Support\Facades\Hash;

readonly class RegisterEmployerDto implements RegisterDtoInterface
{

    public function __construct(
        private string $companyName,
        private string $email,
        private string $password,
        private string $role,
        private string $companyLogo
    ) {
    }

    public function asDatabaseFields(): array
    {
        return [
            'contact_email' => $this->email,
            'company_name' => $this->companyName,
            'company_logo' => $this->companyLogo,
        ];
    }

    public static function fromRequest(EmployerRegisterRequest $request, string $defaultLogo): static
    {
        $data = $request->validated();

        return new static(
            companyName: $data['company'],
            email: $data['email'],
            password: Hash::make($data['password'], ['rounds' => 12]),
            role: User::EMPLOYER,
            companyLogo: $defaultLogo
        );
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
