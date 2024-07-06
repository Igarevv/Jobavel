<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Exceptions\InvalidRoleException;
use App\Persistence\Contracts\AccountRepositoryInterface;
use App\Persistence\Models\User;
use App\Persistence\Repositories\EmployerAccountRepository;

class AccountRepositoryFactory
{

    /**
     * @throws InvalidRoleException
     */
    public function make(): AccountRepositoryInterface
    {
        $role = auth()->user()->role;

        return match ($role) {
            User::EMPLOYER => new EmployerAccountRepository(),
            //User::EMPLOYEE => new EmployeeAccountRepository(),
            default => throw new InvalidRoleException('Tried to get repository for invalid role '.$role)
        };
    }

}
