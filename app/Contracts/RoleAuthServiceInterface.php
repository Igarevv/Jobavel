<?php

namespace App\Contracts;

interface RoleAuthServiceInterface
{

    public function register(RegisterDtoInterface $registerDto);

}
