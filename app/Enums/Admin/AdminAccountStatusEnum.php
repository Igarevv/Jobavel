<?php

namespace App\Enums\Admin;

use function PHPUnit\Framework\matches;

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
}
