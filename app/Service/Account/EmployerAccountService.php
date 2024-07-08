<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Persistence\Models\User;

class EmployerAccountService extends AccountService
{

    private bool $isEmailChanged = false;

    public function __construct()
    {
        parent::__construct(new AccountRepositoryFactory(User::EMPLOYER));
    }

    public function update(string|int $userOd, array $newData, CodeVerificationService $verificationService): void
    {
        $employer = $this->getRepository()->update($userOd, $newData);

        if (! $employer->compareEmails($newData['email'])) {
            $verificationService->sendEmail($userOd, $newData['email']);

            $this->isEmailChanged = true;
        }
    }

    public function isNewContactEmail(): bool
    {
        return $this->isEmailChanged;
    }

}