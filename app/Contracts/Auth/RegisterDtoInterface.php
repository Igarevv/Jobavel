<?php

namespace App\Contracts\Auth;

interface RegisterDtoInterface
{

    public function asDatabaseFields(): array;

    public function getEmail(): string;

    public function getPassword(): string;

    public function getRole(): string;

}
