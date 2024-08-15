<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{

    case EMPLOYER = 'employer';

    case EMPLOYEE = 'employee';

    case ADMIN = 'admin';

    case SUPER_ADMIN = 'super-admin';

    public function roleMainPage(): string
    {
        return match ($this) {
            self::EMPLOYER => self::EMPLOYER->value.'.main',
            self::EMPLOYEE => self::EMPLOYEE->value.'.main',
            default => 'home'
        };
    }

}
