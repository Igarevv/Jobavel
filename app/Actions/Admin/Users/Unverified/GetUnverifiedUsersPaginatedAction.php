<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Unverified;

use App\Persistence\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Str;

class GetUnverifiedUsersPaginatedAction
{
    public function handle(): Paginator
    {
        $users = User::unverified()->simplePaginate(10, ['user_id', 'email', 'created_at']);

        return $this->prepareData($users);
    }

    public function prepareData(Paginator $users)
    {
        return $users->through(function (User $user) {
            return (object)[
                'id' => $user->user_id,
                'idEncrypted' => Str::mask($user->user_id, '*', 5, -2),
                'email' => $user->email,
                'createdAt' => $user->created_at->format('Y-m-d H:i').' '.
                    $user->created_at->getTimezone()
            ];
        });
    }
}