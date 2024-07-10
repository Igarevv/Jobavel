<?php

namespace App\Contracts\Auth;

use App\Persistence\Models\User;

interface RoleAuthServiceInterface
{

    public function register(RegisterDtoInterface $registerDto): User;

}
