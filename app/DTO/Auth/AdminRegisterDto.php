<?php

declare(strict_types=1);

namespace App\DTO\Auth;

readonly final class AdminRegisterDto
{
    public function __construct(
        public string $email,
        public string $firstName,
        public string $lastName,
    ) {
    }
}