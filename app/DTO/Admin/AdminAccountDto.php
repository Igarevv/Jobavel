<?php

namespace App\DTO\Admin;

class AdminAccountDto
{
    public function __construct(
        private ?string $firstName = null,
        private ?string $lastName = null,
        private ?string $email = null
    ) {}

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

}
