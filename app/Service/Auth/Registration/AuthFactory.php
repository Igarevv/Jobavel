<?php

declare(strict_types=1);

namespace App\Service\Auth\Registration;

use App\Contracts\Auth\RoleAuthServiceInterface;
use App\Exceptions\InvalidRoleException;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Models\User;
use App\Service\Auth\Registration\Employee\EmployeeRegister;
use App\Service\Auth\Registration\Employer\EmployerRegister;

readonly class AuthFactory
{

    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    /**
     * @throws InvalidRoleException
     */
    public function makeRegister(string $role): RoleAuthServiceInterface
    {
        return match ($role) {
            User::EMPLOYEE => new EmployeeRegister($this->repository),
            User::EMPLOYER => new EmployerRegister($this->repository),
            default => throw new InvalidRoleException("Try to get register instance on invalid role: $role")
        };
    }

}
