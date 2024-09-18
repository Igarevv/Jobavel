<?php

declare(strict_types=1);

namespace App\DTO\Admin;

use App\Contracts\Admin\AdminActionDtoInterface;
use App\Enums\Rules\BanDurationEnum;
use App\Enums\Rules\ReasonToBanEmployerEnum;
use App\Persistence\Models\Admin;
use App\Persistence\Models\Employer;
use Illuminate\Database\Eloquent\Model;

readonly final class AdminBannedUserDto implements AdminActionDtoInterface
{
    public function __construct(
        private Admin $admin,
        private Model $user,
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
        return $this->user;
    }

    public function getActionableModelId(): string
    {
        return $this->user->getUuid();
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
