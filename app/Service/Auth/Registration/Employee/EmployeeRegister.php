<?php

declare(strict_types=1);

namespace App\Service\Auth\Registration\Employee;

use App\Contracts\Auth\RegisterDtoInterface;
use App\Contracts\Auth\RoleAuthServiceInterface;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Models\User;

class EmployeeRegister implements RoleAuthServiceInterface
{

    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {
    }

    public function register(RegisterDtoInterface $registerDto): User
    {
        return $this->repository->save($registerDto);
    }

}
