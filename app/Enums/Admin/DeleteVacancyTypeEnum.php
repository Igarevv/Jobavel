<?php

namespace App\Enums\Admin;

enum DeleteVacancyTypeEnum: int
{
    case DELETE_TRASH = 0;

    case DELETE_PERMANENTLY = 1;

    public function toActionName(): string
    {
        return match ($this) {
            self::DELETE_PERMANENTLY => 'delete permanently',
            self::DELETE_TRASH => 'trash vacancy'
        };
    }
}
