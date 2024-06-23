<?php

declare(strict_types=1);

namespace App\Service\Auth;

use Illuminate\Support\Facades\Hash;

class PasswordHasher
{

    public function hash(string $password): string
    {
        return Hash::make($password, [
            'rounds' => 12,
        ]);
    }

    public function check(string $input, string $hashed): bool
    {
        return Hash::check($input, $hashed);
    }

}
