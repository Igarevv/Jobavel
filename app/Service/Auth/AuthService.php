<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Contracts\RegisterDtoInterface;
use App\DTO\Auth\RegisterEmployeeDto;
use App\DTO\Auth\RegisterEmployerDto;
use App\Persistence\Models\User;
use App\Service\Auth\Registration\AuthFactory;
use Illuminate\Auth\Events\Registered;

readonly class AuthService
{

    public function __construct(
        private AuthFactory $registerFactory,
        private PasswordHasher $passwordHasher
    ) {}

    public function register(RegisterDtoInterface $registerDto): void
    {
        $roleAuthService = $this->registerFactory->makeRegister(
            $registerDto->getRole()
        );

        $user = $roleAuthService->register($registerDto);

        event(new Registered($user));
    }

    public function createEmployerRegisterDto(array $data): RegisterEmployerDto
    {
        return new RegisterEmployerDto(
            companyName: $data['company'],
            email: $data['email'],
            password: $this->passwordHasher->hash($data['password']),
            role: User::EMPLOYER
        );
    }

    public function createEmployeeRegisterDto(array $data): RegisterEmployeeDto
    {
        return new RegisterEmployeeDto(
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            email: $data['email'],
            password: $this->passwordHasher->hash($data['password']),
            role: User::EMPLOYEE
        );
    }

}
