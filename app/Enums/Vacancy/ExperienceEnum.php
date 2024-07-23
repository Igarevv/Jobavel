<?php

namespace App\Enums\Vacancy;

enum ExperienceEnum: string
{
    case EXPERIENCE_0 = 'without experience';

    case EXPERIENCE_1 = '1+ year';

    case EXPERIENCE_3 = '3+ years';

    case EXPERIENCE_5 = '5+ years';

    case EXPERIENCE_10 = '10+ years';

    public static function experienceToString(float $years): string
    {
        return match (true) {
            $years == 0 => self::EXPERIENCE_0->value,
            $years >= 0 && $years < 3 => self::EXPERIENCE_1->value,
            $years >= 3 && $years < 5 => self::EXPERIENCE_3->value,
            $years >= 5 && $years < 10 => self::EXPERIENCE_5->value,
            $years >= 10 => self::EXPERIENCE_10->value
        };
    }

    public function experienceFromString(): int
    {
        return match ($this) {
            self::EXPERIENCE_0 => 0,
            self::EXPERIENCE_1 => 1,
            self::EXPERIENCE_3 => 3,
            self::EXPERIENCE_5 => 5,
            self::EXPERIENCE_10 => 10,
        };
    }

}
