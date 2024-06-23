<?php

declare(strict_types=1);

namespace App\Persistance\Repositories;

use App\Contracts\RegisterDtoInterface;
use App\Enums\Role;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class UserRepository
{

    protected string $table;

    public function __construct()
    {
        $this->table = config('dbinfo.names.user');
    }

    public function save(RegisterDtoInterface $userData): void
    {
        DB::transaction(function () use ($userData) {
            $id = $this->saveInUserTable($userData);

            $this->saveUserByRole($id, $userData);
        });
    }

    private function saveInUserTable(RegisterDtoInterface $userData): int
    {
        $newId = DB::table($this->table)->insertGetId([
            'email' => $userData->email,
            'password' => $userData->password,
            'user_id' => Uuid::uuid7()->toString(),
            'role' => $userData->role,
        ]);

        return $newId;
    }

    private function saveUserByRole(
        int $id,
        RegisterDtoInterface $userData
    ): void {
        $tableName = Role::tryFrom($userData->role)?->roleTableName();

        $userData = array_merge($userData->toDatabaseContext(), [
            'user_id' => $id,
        ]);

        DB::table($tableName)->insert([$userData]);
    }

}
