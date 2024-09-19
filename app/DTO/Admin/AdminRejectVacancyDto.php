<?php

declare(strict_types=1);

namespace App\DTO\Admin;

use App\Contracts\Admin\AdminLogActionDtoInterface;
use App\Contracts\Admin\AdminReasonEnumInterface;
use App\Enums\Actions\ReasonToRejectVacancyEnum;
use App\Persistence\Models\Admin;
use App\Persistence\Models\Vacancy;
use Illuminate\Database\Eloquent\Model;

readonly final class AdminRejectVacancyDto implements AdminLogActionDtoInterface
{

    public function __construct(
        private Admin $admin,
        private Vacancy $vacancy,
        private ReasonToRejectVacancyEnum $reasonEnum,
        private ?string $comment = null,
    ) {}

    public function getReasonForAction(): AdminReasonEnumInterface
    {
        return $this->reasonEnum;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getAdmin(): Admin
    {
        return $this->admin;
    }

    public function getActionableModel(): Model
    {
        return $this->vacancy;
    }

}
