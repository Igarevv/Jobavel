<?php

namespace App\Persistence\Contracts;

use App\Contracts\User\UserDtoInterface;
use Illuminate\Database\Eloquent\Model;

interface AccountRepositoryInterface
{
    public function getById(string|int $userId, array $columns = ['*']): Model;

    public function update(Model|string|int $model, UserDtoInterface $user): Model;
}
