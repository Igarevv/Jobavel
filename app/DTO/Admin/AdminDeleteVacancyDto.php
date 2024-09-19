<?php

namespace App\DTO\Admin;

use App\Contracts\Admin\AdminLogActionDtoInterface;
use App\Enums\Admin\DeleteVacancyTypeEnum;
use App\Enums\Actions\ReasonToDeleteVacancyEnum;
use App\Persistence\Models\Admin;
use App\Persistence\Models\Vacancy;

readonly final class AdminDeleteVacancyDto implements AdminLogActionDtoInterface
{

    public function __construct(
        private Admin $admin,
        private Vacancy $vacancy,
        private ReasonToDeleteVacancyEnum $reasonEnum,
        private DeleteVacancyTypeEnum $adminDeleteVacancyEnum,
        private ?string $comment = null
    ) {}

    public function getAdmin(): Admin
    {
        return $this->admin;
    }

    public function getActionableModel(): Vacancy
    {
        return $this->vacancy;
    }

    public function getReasonForAction(): ReasonToDeleteVacancyEnum
    {
        return $this->reasonEnum;
    }

    public function deleteVacancyTypeEnum(): DeleteVacancyTypeEnum
    {
        return $this->adminDeleteVacancyEnum;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

}
