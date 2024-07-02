<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\Contracts\RegisterDtoInterface as Dto;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    public function save(Dto $userData): User
    {
        return DB::transaction(function () use ($userData) {
            $user = $this->saveInUserTable($userData);

            $this->saveUserByRole($user, $userData);

            return $user;
        });
    }

    private function saveInUserTable(Dto $userData): User|Builder
    {
        $user = User::query()->create([
            'email' => $userData->getEmail(),
            'password' => $userData->getPassword(),
            'role' => $userData->getRole(),
        ]);

        return $user;
    }

    private function saveUserByRole(User $user, Dto $userData): void
    {
        $modelByRole = $user->getRole()->getAssociatedModelByRole($user);

        $modelByRole->create(array_merge($userData->asDatabaseFields(), [
            'user_id' => $user->id,
        ]));
    }

}
