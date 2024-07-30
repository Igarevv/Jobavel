<?php

declare(strict_types=1);

namespace App\Persistence\Contracts;

interface VerificationCodeRepositoryInterface
{
    public function saveVerificationCode(string $userId, string $newEmail, int $code): int;

    public function setNewEmployerContactEmail(string $userId, string $email): void;

    public function getCodeByUserId(string $userId): ?\stdClass;

    public function updateCodeForResendingAction(int $code, string $userId);

    public function deleteCode(string $userId): void;
}