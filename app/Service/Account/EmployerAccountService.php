<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Events\ContactEmailUpdatedEvent;

class EmployerAccountService extends AccountService
{
    private bool $isEmailChanged = false;

    public function update(string|int $id, array $newData): void
    {
        $employer = $this->getInitializedRepository()->update($id, $newData);

        if ($employer->wasChanged('contact_email')) {
            $code = $this->getInitializedRepository()
                ->generateAndSaveVerificationCode($employer->employer_id);

            event(new ContactEmailUpdatedEvent($code, $employer->contact_email));

            $this->isEmailChanged = true;
        }
    }

    public function isEmailChangedAfterUpdate(): bool
    {
        return $this->isEmailChanged;
    }
}