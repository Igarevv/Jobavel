<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Events\ContactEmailUpdatedEvent;
use App\Exceptions\InvalidVerificationCodeException;
use App\Exceptions\VerificationCodeTimeExpiredException;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    /**
     * @throws VerificationCodeTimeExpiredException
     * @throws InvalidVerificationCodeException
     */
    public function verifyCodeFromRequest(int $code, string|int $user_id): void
    {
        $employer = $this->getInitializedRepository()->getById($user_id);

        if (! $employer) {
            throw new ModelNotFoundException("Try to get model when verify code for user id".$user_id);
        }

        $codeInDb = $this->getInitializedRepository()->getCodeByUserId($employer->employer_id);

        if (now() > $codeInDb->expires_at) {
            $this->regenerateExpiredCode($employer);
        }

        $this->ensureCodesAreSame($code, $codeInDb->code);
        
        $this->getInitializedRepository()->setEmployerContactEmailVerified($user_id);
    }

    public function isEmailChangedAfterUpdate(): bool
    {
        return $this->isEmailChanged;
    }

    protected function regenerateExpiredCode(Employer $employer): void
    {
        $code = $this->getInitializedRepository()->generateAndSaveVerificationCode($employer->employer_id);

        event(new ContactEmailUpdatedEvent($code, $employer->contact_email));

        throw new VerificationCodeTimeExpiredException('Verification code time expired. New code was sent by email');
    }

    protected function ensureCodesAreSame(int $code, int $codeFromDb): void
    {
        if ($code !== $codeFromDb) {
            throw new InvalidVerificationCodeException('Invalid code. Please, try again');
        }
    }

}