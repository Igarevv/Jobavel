<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Contracts\RegisterDtoInterface;
use App\DTO\Auth\RegisterEmployeeDto;
use App\DTO\Auth\RegisterEmployerDto;
use App\Service\Auth\Registration\RegisterFactory;

readonly class AuthService
{

    public function __construct(
        private RegisterFactory $registerFactory,
        private PasswordHasher $passwordHasher
    ) {}

    public function register(RegisterDtoInterface $registerDto): void
    {
        $roleAuthService = $this->registerFactory->make(
            $registerDto->getRole()
        );

        $roleAuthService->register($registerDto);
    }

    public function createEmployerRegisterDto(array $data): RegisterEmployerDto
    {
        return new RegisterEmployerDto(
            companyName: $data['company'],
            email: $data['email'],
            password: $this->passwordHasher->hash($data['password'])
        );
    }

    public function createEmployeeRegisterDto(array $data): RegisterEmployeeDto
    {
        return new RegisterEmployeeDto(
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            email: $data['email'],
            password: $this->passwordHasher->hash($data['password'])
        );
    }

}
