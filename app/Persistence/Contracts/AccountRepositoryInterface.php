<?php

namespace App\Persistence\Contracts;

use Illuminate\Database\Eloquent\Model;

interface AccountRepositoryInterface
{
    public function getById(string|int $userId, ?array $columns = []): Model;

    public function update(Model|string|int $model, array $data): Model;
}
