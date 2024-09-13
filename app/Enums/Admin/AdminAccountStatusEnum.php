<?php

namespace App\Enums\Admin;

enum AdminAccountStatusEnum: int
{
    case ACTIVE = 0;

    case DEACTIVATED = 2;

    case PENDING_TO_AUTHORIZE = 3;

    public function toString(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::DEACTIVATED => 'Deactivated',
            self::PENDING_TO_AUTHORIZE => 'Pending'
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            self::ACTIVE => '#43d33c',
            self::DEACTIVATED => '#f9322c',
            self::PENDING_TO_AUTHORIZE => '#ffb40a'
        };
    }
}
