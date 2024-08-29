<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\TemporarilyDeleted;

use App\DTO\Admin\AdminSearchDto;
use App\Persistence\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Str;

class GetTemporarilyDeletedUserBySearchAction
{
    public function __construct(
        private GetTemporarilyDeletedUsersAction $temporarilyDeletedUsersAction
    ) {
    }

    public function handle(AdminSearchDto $searchDto): Paginator|array
    {
        if (Str::of($searchDto->getSearchable())->trim()->value() === '') {
            return $this->temporarilyDeletedUsersAction->handle();
        }

        return $this->prepareData($this->fetchTemporarilyDeletedUsers($searchDto));
    }

    private function fetchTemporarilyDeletedUsers(AdminSearchDto $searchDto): ?User
    {
        return User::onlyTrashed()
            ->search($searchDto)
            ->first(['user_id', 'email', 'created_at', 'deleted_at']);
    }

    private function prepareData(?User $user): array
    {
        if (! $user) {
            return [];
        }

        $timezone = $user->created_at->getTimezone();
        return [
            (object)[
                'id' => $user->user_id,
                'idEncrypted' => Str::mask($user->user_id, '*', 5, -2),
                'email' => $user->email,
                'createdAt' => $user->created_at->format('Y-m-d H:i').' '.$timezone,
                'deletedAt' => $user->deleted_at->format('Y-m-d H:i').' '.$timezone
            ]
        ];
    }
}