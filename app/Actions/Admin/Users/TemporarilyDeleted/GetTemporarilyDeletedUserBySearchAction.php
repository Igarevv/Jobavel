<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\TemporarilyDeleted;

use App\DTO\Admin\AdminSearchDto;
use App\Persistence\Models\User;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetTemporarilyDeletedUserBySearchAction
{
    public function __construct(
        private GetTemporarilyDeletedUsersAction $temporarilyDeletedUsersAction
    ) {
    }

    public function handle(AdminSearchDto $searchDto): LengthAwarePaginator
    {
        if (Str::of($searchDto->getSearchable())->trim()->value() === '') {
            return $this->temporarilyDeletedUsersAction->handle(
                SortedValues::fromRequest('creation-time')
            );
        }

        return $this->prepareData($this->fetchTemporarilyDeletedUsers($searchDto));
    }

    private function fetchTemporarilyDeletedUsers(AdminSearchDto $searchDto): LengthAwarePaginator
    {
        return User::onlyTrashed()
            ->search($searchDto)
            ->paginate(10, ['user_id', 'email', 'created_at', 'deleted_at']);
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