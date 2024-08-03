<?php

declare(strict_types=1);

namespace App\Service\Account\Employer;

use App\DTO\Employer\EmployerPersonalInfoDto;
use App\Persistence\Models\Employer;
use App\Persistence\Models\User;
use App\Service\Account\AccountRepositoryFactory;
use App\Service\Account\AccountService;

final class EmployerAccountService extends AccountService
{

    private bool $isEmailChanged = false;


    public function __construct()
    {
        parent::__construct(new AccountRepositoryFactory(User::EMPLOYER));
    }

    public function update(string|int $userId, EmployerPersonalInfoDto $employerDto): Employer|false
    {
        $employer = $this->getRepository()->update($userId, $employerDto);

        if (! $employer->wasChanged() && ! $this->isNewContactEmail($employer, $employerDto->contactEmail)) {
            return false;
        }

        return $employer;
    }

    public function isNewContactEmail(Employer $employer, string $newEmail): bool
    {
        return ! $employer->compareEmails($newEmail);
    }

}