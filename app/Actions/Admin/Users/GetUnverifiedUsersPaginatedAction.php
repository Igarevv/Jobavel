<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users;

use App\Persistence\Models\User;
use Illuminate\Pagination\Paginator;

class GetUnverifiedUsersPaginatedAction
{
    public function handle(): Paginator
    {
        $users = User::unverified()->simplePaginate(10, ['user_id', 'email', 'created_at']);

        return $users->through(function (User $user) {
            return (object)[
                'email' => $user->email,
                'userId' => $user->user_id,
                'createdAt' => $user->created_at->format('Y-m-d H:i').' UTC'
            ];
        });
    }
}