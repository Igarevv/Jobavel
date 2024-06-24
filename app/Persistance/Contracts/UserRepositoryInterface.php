<?php

namespace App\Persistance\Contracts;

use App\Contracts\RegisterDtoInterface;

interface UserRepositoryInterface
{

    public function save(RegisterDtoInterface $userData): void;

}
