<?php

namespace App\Contracts;

use App\Persistence\Models\User;

interface RoleAuthServiceInterface
{

    public function register(RegisterDtoInterface $registerDto): User;

}
