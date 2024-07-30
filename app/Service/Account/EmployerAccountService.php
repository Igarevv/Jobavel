<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Persistence\Models\Employer;
use App\Persistence\Models\User;

final class EmployerAccountService extends AccountService
{

    private bool $isEmailChanged = false;


    public function __construct()
    {
        parent::__construct(new AccountRepositoryFactory(User::EMPLOYER));
    }

    public function update(string|int $userId, array $newData): Employer|false
    {
        $employer = $this->getRepository()->update($userId, $newData);

        if (! $employer->wasChanged() && ! $this->isNewContactEmail($employer, $newData['email'])) {
            return false;
        }

        return $employer;
    }

    public function isNewContactEmail(Employer $employer, string $newEmail): bool
    {
        return ! $employer->compareEmails($newEmail);
    }

}