<?php

namespace App\Enums\Admin;

use App\Contracts\Admin\SearchEnumInterface;

enum AdminDeletedUserSearchEnum: int implements SearchEnumInterface
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
            self::ID => 'User ID',
            self::EMAIL => 'Email'
        };
    }

    public static function columns(): array
    {
        return [
            self::ID->value => 'User ID',
            self::EMAIL->value => 'Email'
        ];
    }
}
