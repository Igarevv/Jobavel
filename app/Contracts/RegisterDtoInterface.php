<?php

namespace App\Contracts;

interface RegisterDtoInterface
{

    public function asDatabaseFields(): array;

    public function getEmail(): string;

    public function getPassword(): string;

    public function getRole(): string;

}
