<?php

namespace App\DTO\Admin;

use App\Enums\Admin\DeleteVacancyTypeEnum;
use App\Enums\Reason\ReasonToDeleteVacancyEnum;
use App\Persistence\Models\Admin;
use App\Persistence\Models\Vacancy;

readonly final class AdminDeleteVacancyDto
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

    public function getVacancy(): Vacancy
    {
        return $this->vacancy;
    }

    public function reasonToDeleteVacancyEnum(): ReasonToDeleteVacancyEnum
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
