<?php

namespace App\Enums\Admin;

use App\Contracts\Admin\SearchEnumInterface;

enum AdminVacanciesSearchEnum:int implements SearchEnumInterface
{

    case TITLE = 0;

    case EMPLOYMENT_TYPE = 1;

    case COMPANY = 2;

    public function toDbField(): string
    {
        return match ($this) {
            self::TITLE => 'title',
            self::EMPLOYMENT_TYPE => 'employment_type',
            self::COMPANY => 'company_name'
        };
    }

    public static function columns(): array
    {
        return [
            self::TITLE->value => 'Title',
            self::EMPLOYMENT_TYPE->value => 'Employment',
            self::COMPANY->value => 'Company'
        ];
    }

    public function toString(): string
    {
        return match ($this) {
            self::TITLE => 'Title',
            self::EMPLOYMENT_TYPE => 'Employment',
            self::COMPANY => 'Company'
        };
    }

}
