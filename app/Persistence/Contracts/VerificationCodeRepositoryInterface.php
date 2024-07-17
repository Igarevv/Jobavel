<?php

declare(strict_types=1);

namespace App\Persistence\Contracts;

interface VerificationCodeRepositoryInterface
{
    public function saveVerificationCode(string|int $userId, string $newEmail, int $code): int;

    public function setNewEmployerContactEmail(string|int $userId, string $email): void;

    public function getCodeByUserId(string|int $userId): ?\stdClass;

    public function updateCodeForResendingAction(int $code, string|int $userId);
}