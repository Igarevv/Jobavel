<?php

declare(strict_types=1);

namespace App\Service\Auth\Registration\Employer;

use App\Contracts\RegisterDtoInterface;
use App\Contracts\RoleAuthServiceInterface;
use App\Persistence\Contracts\UserRepositoryInterface;

class EmployerRegister implements RoleAuthServiceInterface
{

    public function __construct(
        private readonly UserRepositoryInterface $repository
    ) {}

    public function register(RegisterDtoInterface $registerDto): void
    {
        $this->repository->save($registerDto);
    }

}
