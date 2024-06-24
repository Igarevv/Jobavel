<?php

declare(strict_types=1);

namespace App\Service\Auth\Registration;

use App\Contracts\RoleAuthServiceInterface;
use App\Enums\Role;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Service\Auth\Registration\Employee\EmployeeRegister;
use App\Service\Auth\Registration\Employer\EmployerRegister;
use InvalidArgumentException;

class RegisterFactory
{

    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {}

    public function make(string $role): RoleAuthServiceInterface
    {
        return match ($role) {
            Role::EMPLOYEE->value => new EmployeeRegister($this->repository),
            Role::EMPLOYER->value => new EmployerRegister($this->repository),
            default => throw new InvalidArgumentException(
                'Invalid role provided'
            )
        };
    }

}
