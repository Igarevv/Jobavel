<?php

namespace App\Enums\Admin;

use App\Contracts\Admin\SearchEnumInterface;

enum AdminEmployeesSearchEnum: int implements SearchEnumInterface
{
    case ID = 0;

    case NAME = 1;

    case EMAIL = 2;

    case POSITION = 3;

    public function toDbField(): string
    {
        return match ($this) {
            self::ID => 'employer_id',
            self::EMAIL => 'email',
            self::POSITION => 'position'
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::ID => 'ID',
            self::NAME => 'Full name',
            self::EMAIL => 'Email',
            self::POSITION => 'Position'
        };
    }

    public static function columns(): array
    {
        return [
            self::ID->value => 'ID',
            self::NAME->value => 'Full name',
            self::EMAIL->value => 'Email',
            self::POSITION->value => 'Position'
        ];
    }
}
