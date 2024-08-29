<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\TemporarilyDeleted;

use App\Persistence\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Str;

class GetTemporarilyDeletedUsersAction
{
    public function handle(): Paginator
    {
        $users = User::onlyTrashed()->simplePaginate(10, [
            'user_id',
            'email',
            'created_at',
            'deleted_at'
        ]);

        return $this->prepareData($users);
    }

    private function prepareData(Paginator $users): Paginator
    {
        return $users->through(function (User $user) {
            $timezone = $user->created_at->getTimezone();

            return (object)[
                'id' => $user->user_id,
                'idEncrypted' => Str::mask($user->user_id, '*', 5, -2),
                'email' => $user->email,
                'createdAt' => $user->created_at->format('Y-m-d H:i').' '.$timezone,
                'deletedAt' => $user->deleted_at->format('Y-m-d H:i').' '.$timezone
            ];
        });
    }
}