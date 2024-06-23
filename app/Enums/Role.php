<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{

    case EMPLOYER = 'employer';

    case EMPLOYEE = 'employee';

    public function roleMainPage(): string
    {
        return match ($this) {
            self::EMPLOYER => self::EMPLOYER->value.'.main',
            self::EMPLOYEE => self::EMPLOYEE->value.'.main',
            default => 'home'
        };
    }

    public function roleTableName(): ?string
    {
        return match ($this) {
            self::EMPLOYER => config('dbinfo.names.employer'),
            self::EMPLOYEE => config('dbinfo.names.employee'),
            default => null
        };
    }

}
