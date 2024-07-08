<?php

declare(strict_types=1);

namespace App\Persistence\Contracts;

use App\Persistence\Models\Employer;

interface VerificationCodeRepositoryInterface
{
    public function saveVerificationCode(string|int $userId, string $newEmail, int $code): int;

    public function setNewEmployerContactEmail(Employer $employer, string $email): void;

    public function getCodeByUserId(string|int $userId): ?\stdClass;
}