<?php

namespace App\Enums\Admin;

use App\Enums\Actions\AdminActionEnum;

enum DeleteVacancyTypeEnum: int
{
    case DELETE_TRASH = 0;

    case DELETE_PERMANENTLY = 1;

    public function toActionName(): AdminActionEnum
    {
        return match ($this) {
            self::DELETE_PERMANENTLY => AdminActionEnum::DELETE_VACANCY_PERM_ACTION,
            self::DELETE_TRASH => AdminActionEnum::DELETE_VACANCY_TEMP_ACTION
        };
    }
}
