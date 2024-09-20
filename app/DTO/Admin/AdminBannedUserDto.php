<?php

declare(strict_types=1);

namespace App\DTO\Admin;

use App\Contracts\Admin\AdminLogActionDtoInterface;
use App\Enums\Actions\BanDurationEnum;
use App\Enums\Actions\ReasonToBanEmployerEnum;
use App\Persistence\Models\Admin;
use Illuminate\Database\Eloquent\Model;

readonly final class AdminBannedUserDto implements AdminLogActionDtoInterface
{
    public function __construct(
        private Admin $admin,
        private Model $actionableUser,
        private ReasonToBanEmployerEnum $reasonToBanEnum,
        private BanDurationEnum $banDurationEnum,
        private ?string $comment = null
    ) {}

    public function getAdmin(): Admin
    {
        return $this->admin;
    }

    public function getActionableModel(): Model
    {
        return $this->actionableUser;
    }

    public function getActionableModelId(): string
    {
        return $this->actionableUser->userId();
    }

    public function getActionableModelEmail(): string
    {
        return $this->actionableUser->getAccountEmail();
    }

    public function getReasonForAction(): ReasonToBanEmployerEnum
    {
        return $this->reasonToBanEnum;
    }

    public function getBanDurationEnum(): BanDurationEnum
    {
        return $this->banDurationEnum;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

}
