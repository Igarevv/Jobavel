<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\TemporarilyDeleted;

use App\Persistence\Models\User;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetTemporarilyDeletedUsersAction
{
    public function handle(SortedValues $sortedValues): LengthAwarePaginator
    {
        $users = User::onlyTrashed()
            ->sortBy($sortedValues)
            ->paginate(10, [
                'user_id',
                'email',
                'created_at',
                'deleted_at'
            ]);

        return $this->prepareData($users);
    }

    private function prepareData(LengthAwarePaginator $users): LengthAwarePaginator
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