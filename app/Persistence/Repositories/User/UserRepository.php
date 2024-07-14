<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\User;

use App\Contracts\Auth\RegisterDtoInterface;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    public function save(RegisterDtoInterface $userData): User
    {
        return DB::transaction(function () use ($userData) {
            $user = $this->saveInUserTable($userData);

            $user->assignRole($userData->getRole());

            $this->saveUserByRole($user, $userData);

            return $user;
        });
    }

    public function getById(int|string $id): ?User
    {
        $columnName = is_numeric($id) ? 'id' : 'user_id';

        return User::query()->where($columnName, $id)->first([
            'user_id', 'email', 'role', 'is_confirmed', 'created_at',
        ]);
    }

    private function saveInUserTable(RegisterDtoInterface $userData): User|Builder
    {
        $user = User::query()->create([
            'email' => $userData->getEmail(),
            'password' => $userData->getPassword(),
            'role' => $userData->getRole(),
        ]);

        return $user;
    }

    private function saveUserByRole(User $user, RegisterDtoInterface $userData): void
    {
        $modelByRole = $user->getRelationByUserRole();

        $modelByRole->create(array_merge($userData->asDatabaseFields(), [
            'user_id' => $user->id,
        ]));
    }

}
