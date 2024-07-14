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

    public function update(string|int $userId, array $newData, CodeVerificationService $verificationService): Employer
    {
        $employer = $this->getRepository()->update($userId, $newData);

        if (! $employer->compareEmails($newData['email'])) {
            $verificationService->sendEmail($userId, $newData['email']);

            $this->isEmailChanged = true;
        }

        return $employer;
    }

    public function isNewContactEmail(): bool
    {
        return $this->isEmailChanged;
    }

}