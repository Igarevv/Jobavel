<?php

declare(strict_types=1);

namespace App\Service\Admin\AdminActions;

use App\DTO\Admin\AdminBannedUserDto;
use App\Enums\Rules\BanDurationEnum;
use App\Exceptions\UserAlreadyPermanentlyBannedException;
use App\Exceptions\UserHasAlreadyBannedException;
use App\Persistence\Models\BannedUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class AdminBanService
{
    public const BANNED_PERMANENTLY = 0;

    public const BANNED_TEMPORARILY = 1;

    public function __construct(
        protected AdminLogActionService $logActionService
    ) {}

    /**
     * @throws \App\Exceptions\BanException
     * @throws RuntimeException
     */
    public function ban(AdminBannedUserDto $dto): int
    {
        $banHistory = $this->getBanHistoryForUser($dto->getActionableModelId());

        $lastBan = $banHistory->last();

        if ($lastBan?->banned_until && $lastBan?->banned_until > now()) {
            throw new UserHasAlreadyBannedException();
        }

        if ($banHistory->last()?->duration === BanDurationEnum::PERMANENT) {
            throw new UserAlreadyPermanentlyBannedException();
        }

        return $this->banAndLogUser($dto, $banHistory);
    }

    public function getBanHistoryForUser(string $userId): Collection
    {
        return BannedUser::query()->user($userId)->get();
    }

    protected function giveTemporarilyBan(AdminBannedUserDto $dto): int
    {
        $ban = BannedUser::create([
            'user_id' => $dto->getActionableModelId(),
            'reason_type' => $dto->getReasonForAction()->value,
            'comment' => $dto->getComment(),
            'duration' => $dto->getBanDurationEnum()->value,
            'banned_until' => $dto->getBanDurationEnum()->toDateTime(),
        ]);

        if (! $ban->wasRecentlyCreated) {
            throw new RuntimeException('Ban action was not applied');
        }

        return self::BANNED_TEMPORARILY;
    }

    protected function givePermanentBan(AdminBannedUserDto $dto): int
    {
        $ban = BannedUser::create([
            'user_id' => $dto->getActionableModelId(),
            'reason_type' => $dto->getReasonForAction()->value,
            'comment' => $dto->getComment(),
            'duration' => BanDurationEnum::PERMANENT->value,
        ]);

        if (! $ban->wasRecentlyCreated) {
            throw new RuntimeException('Ban action was not applied');
        }

        return self::BANNED_PERMANENTLY;
    }

    protected function banAndLogUser(AdminBannedUserDto $dto, Collection $banHistory): int
    {
        return DB::transaction(function () use($dto, $banHistory) {
            if ($banHistory->count() >= 2) {
                $result = $this->givePermanentBan($dto);
            } else {
                $result = $this->giveTemporarilyBan($dto);
            }

            $this->logActionService->log($dto, 'ban');

            return $result;
        });
    }
}
