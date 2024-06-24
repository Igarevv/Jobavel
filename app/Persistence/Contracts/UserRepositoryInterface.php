<?php

namespace App\Persistence\Contracts;

use App\Contracts\RegisterDtoInterface;

interface UserRepositoryInterface
{

    public function save(RegisterDtoInterface $userData): void;

}
