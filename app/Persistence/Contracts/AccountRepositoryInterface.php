<?php

namespace App\Persistence\Contracts;

use Illuminate\Database\Eloquent\Model;

interface AccountRepositoryInterface
{

    public function getById(string|int $userId): ?Model;

    public function update(string|int $userId, array $data): Model;

    public function generateAndSaveVerificationCode(string|int $userId): int;
}
