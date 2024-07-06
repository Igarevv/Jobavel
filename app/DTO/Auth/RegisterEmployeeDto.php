<?php

declare(strict_types=1);

namespace App\DTO\Auth;

use App\Contracts\RegisterDtoInterface;
use App\Http\Requests\EmployeeRegisterRequest;
use App\Persistence\Models\User;
use Illuminate\Support\Facades\Hash;

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
        ];
    }

    public static function fromRequest(EmployeeRegisterRequest $request): static
    {
        $data = $request->validated();

        return new static(
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            email: $data['email'],
            password: Hash::make($data['password'], ['rounds' => 12]),
            role: User::EMPLOYEE
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
