<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\RegisterDtoInterface;
use App\Http\Requests\EmployerRegisterRequest;
use App\Persistence\Models\User;
use Illuminate\Support\Facades\Hash;

readonly class RegisterEmployerDto implements RegisterDtoInterface
{

    public function __construct(
        private string $companyName,
        private string $email,
        private string $password,
        private string $role
    ) {
    }

    public function asDatabaseFields(): array
    {
        return [
            'contact_email' => $this->email,
            'company_name' => $this->companyName,
            'company_logo' => config('app.logo'),
        ];
    }

    public static function fromRequest(EmployerRegisterRequest $request): static
    {
        $data = $request->validated();

        return new static(
            companyName: $data['company'],
            email: $data['email'],
            password: Hash::make($data['password'], ['rounds' => 12]),
            role: User::EMPLOYER
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
