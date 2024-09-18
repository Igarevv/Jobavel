<?php

namespace App\Enums\Admin;

use App\Contracts\Admin\SearchEnumInterface;

enum AdminBannedSearchEnum:int implements SearchEnumInterface
{

    case ID = 0;

    public function toDbField(): string
    {
        return match ($this) {
            self::ID => 'user_id'
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::ID => 'ID'
        };
    }

}
