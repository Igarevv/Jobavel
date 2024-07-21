<?php

namespace App\Enums\Vacancy;

enum EmploymentEnum: string
{
    case EMPLOYMENT_OFFICE = 'office';

    case EMPLOYMENT_REMOTE = 'remote';

    case EMPLOYMENT_PART_TIME = 'part-time';

    case EMPLOYMENT_MIXED = 'office and remote';

    public function toString(): string
    {
        return match ($this) {
            self::EMPLOYMENT_OFFICE => 'Office',
            self::EMPLOYMENT_REMOTE => 'Remote',
            self::EMPLOYMENT_MIXED => 'Office / remote',
            self::EMPLOYMENT_PART_TIME => 'Part-time'
        };
    }
}
