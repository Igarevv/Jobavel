<?php

namespace App\Enums\Admin;

use App\Contracts\Admin\SearchEnumInterface;

enum AdminEmployersSearchEnum: int implements SearchEnumInterface
{
    case ID = 0;

    case COMPANY = 1;

    case ACCOUNT_EMAIL = 2;

    case CONTACT_EMAIL = 3;

    public function toDbField(): string
    {
        return match ($this) {
            self::ID => 'employer_id',
            self::COMPANY => 'company_name',
            self::CONTACT_EMAIL => 'contact_email',
            self::ACCOUNT_EMAIL => 'email',
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::ID => 'ID',
            self::COMPANY => 'Company name',
            self::ACCOUNT_EMAIL => 'Account email',
            self::CONTACT_EMAIL => 'Contact email',
        };
    }

    public static function columns(): array
    {
        return [
            self::ID->value => 'ID',
            self::COMPANY->value => 'Company name',
            self::ACCOUNT_EMAIL->value => 'Account email',
            self::CONTACT_EMAIL->value => 'Contact email',
        ];
    }
}
