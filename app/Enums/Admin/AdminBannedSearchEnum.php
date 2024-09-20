<?php

namespace App\Enums\Admin;

use App\Contracts\Admin\SearchEnumInterface;

enum AdminBannedSearchEnum:int implements SearchEnumInterface
{

    case ID = 0;

    case EMAIL = 1;

    public function toDbField(): string
    {
        return match ($this) {
            self::ID => 'user_id',
            self::EMAIL => 'email'
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::ID => 'ID',
            self::EMAIL => 'Email'
        };
    }

}
