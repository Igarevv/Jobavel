<?php

namespace App\Enums\Actions;

enum AdminActionEnum: int
{
    case BAN_USER_ACTION = 0;

    case REJECT_VACANCY_ACTION = 1;

    case DELETE_VACANCY_PERM_ACTION = 2;

    case DELETE_VACANCY_TEMP_ACTION = 3;

    public function toString(): string
    {
        return match ($this) {
            self::BAN_USER_ACTION => 'ban user',
            self::REJECT_VACANCY_ACTION => 'reject vacancy',
            self::DELETE_VACANCY_PERM_ACTION => 'delete vacancy permanently',
            self::DELETE_VACANCY_TEMP_ACTION => 'delete vacancy temporarily'
        };
    }
}
