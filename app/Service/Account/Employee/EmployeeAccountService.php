<?php

declare(strict_types=1);

namespace App\Service\Account\Employee;

use App\DTO\Employee\EmployeePersonalInfoDto;
use App\Persistence\Models\Employee;
use App\Persistence\Models\User;
use App\Service\Account\AccountRepositoryFactory;
use App\Service\Account\AccountService;

class EmployeeAccountService extends AccountService
{

    public function __construct()
    {
        parent::__construct(new AccountRepositoryFactory(User::EMPLOYEE));
    }


    public function updatePersonalData(string|int $userId, EmployeePersonalInfoDto $employerDto): Employee|false
    {
        $employee = $this->getRepository()->update($userId, $employerDto);

        if (! $employee->wasChanged()) {
            return false;
        }

        return $employee;
    }
}
