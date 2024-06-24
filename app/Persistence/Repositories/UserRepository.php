<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\Contracts\RegisterDtoInterface;
use App\Enums\Role;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    protected string $table;

    public function __construct()
    {
        $this->table = config('dbinfo.names.user');
    }

    public function save(RegisterDtoInterface $userData): void
    {
        DB::transaction(function () use ($userData) {
            $user = $this->saveInUserTable($userData);

            $this->saveUserByRole($user, $userData);
        });
    }

    private function saveInUserTable(RegisterDtoInterface $userData): User
    {
        $user = User::query()->create([
            'email' => $userData->getEmail(),
            'password' => $userData->getPassword(),
            'role' => $userData->getRole(),
        ]);

        return $user;
    }

    private function saveUserByRole(
        User $user,
        RegisterDtoInterface $userData
    ): void {
        $role = Role::tryFrom($userData->getRole());
        if ( ! $role) {
            throw new InvalidArgumentException('Invalid role type');
        }

        $modelByRole = $role->getModelByRole($user);
        if ( ! $modelByRole) {
            throw new InvalidArgumentException('Model to this role not found');
        }

        $modelByRole->create(array_merge($userData->asDatabaseFields(), [
            'user_id' => $user->id,
        ]));
    }

}
