<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Banned;

use App\DTO\Admin\AdminSearchDto;
use App\Persistence\Models\BannedUser;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Str;

class GetBannedUsersPaginatedAction
{
    public function handle(AdminSearchDto $dto, SortedValues $sortedValues): Paginator
    {
        if (Str::of($dto->getSearchable())->trim()->value() === '') {
            return $this->prepareData($this->getSortedOnly($sortedValues));
        }

        return $this->prepareData($this->getSearchedSorted($dto, $sortedValues));
    }

    private function getSortedOnly(SortedValues $sortedValues): Paginator
    {
        return BannedUser::sortBy($sortedValues)
            ->paginate(10);
    }

    private function getSearchedSorted(AdminSearchDto $dto, SortedValues $sortedValues): Paginator
    {
        return BannedUser::query()->search($dto)
            ->sortBy($sortedValues)
            ->paginate(10);
    }

    private function prepareData(Paginator $bannedUsers): Paginator
    {
        return $bannedUsers->through(function (BannedUser $bannedUser) {
            return (object) [
                'id' => $bannedUser->user_id,
                'idEncrypted' => Str::mask($bannedUser->user_id, '*', 5, -2),
                'email' => $bannedUser->email,
                'reason' => $bannedUser->reason_type->toString(),
                'duration' => $bannedUser->duration->toString(),
                'comment' => $bannedUser->comment,
                'bannedUntil' => $bannedUser->bannedUntil(),
                'bannedAt' => $bannedUser->banned_at->format('Y-m-d').' '.
                    $bannedUser->banned_at->getTimezone()
            ];
        });
    }
}
