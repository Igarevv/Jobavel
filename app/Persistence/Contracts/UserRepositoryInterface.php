<?php

namespace App\Persistence\Contracts;

use App\Contracts\Auth\RegisterDtoInterface;
use App\Persistence\Models\User;

interface UserRepositoryInterface
{

    public function save(RegisterDtoInterface $userData): User;

    public function getById(string|int $id): ?User;

}
