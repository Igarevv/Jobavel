<?php

declare(strict_types=1);

namespace App\Service\Account;

use App\Events\ContactEmailUpdatedEvent;
use App\Exceptions\InvalidVerificationCodeException;
use App\Exceptions\VerificationCodeTimeExpiredException;
use App\Persistence\Contracts\VerificationCodeRepositoryInterface;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CodeVerificationService
{
    public function __construct(
        protected VerificationCodeRepositoryInterface $verificationRepository
    ) {
    }

    public function verifyCodeFromRequest(int $code, string|int $user_id): void
    {
        $employer = Employer::byUuid($user_id)->first();

        if (! $employer) {
            throw new ModelNotFoundException("Try to get model when verify code for user id".$user_id);
        }

        $codeInDb = $this->verificationRepository->getCodeByUserId($employer->employer_id);

        if (! $codeInDb || now() > $codeInDb->expires_at) {
            $this->regenerateExpiredCode($employer, $codeInDb->new_contact_email);
        }

        $this->ensureCodesAreSame($code, $codeInDb->code);

        $this->verificationRepository->setNewEmployerContactEmail($employer, $codeInDb->new_contact_email);
    }

    public function sendEmail(string|int $userId, string $email): bool
    {
        $code = $this->verificationRepository
            ->saveVerificationCode($userId, $email, $this->generateCode());

        event(new ContactEmailUpdatedEvent($code, $email));

        return true;
    }

    public function resendEmail(string|int $userId): void
    {
        $verificationData = $this->verificationRepository->getCodeByUserId($userId);

        if ($verificationData) {
            event(new ContactEmailUpdatedEvent($this->generateCode(), $verificationData->new_contanct_email));
        }
    }

    protected function regenerateExpiredCode(Employer $employer, string $email): void
    {
        $this->sendEmail($employer->employer_id, $email);

        throw new VerificationCodeTimeExpiredException('Verification code time expired. New code was sent by email');
    }

    protected function ensureCodesAreSame(int $code, int $codeFromDb): void
    {
        if ($code !== $codeFromDb) {
            throw new InvalidVerificationCodeException('Invalid code. Please, try again');
        }
    }

    protected function generateCode(): int
    {
        return random_int(100_000, 999_999);
    }

}