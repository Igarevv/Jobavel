<?php

namespace App\Enums\Rules;

use Illuminate\Support\Carbon;

enum BanDurationEnum: int
{
    case DAY = 0;

    case THREE_DAYS = 1;

    case WEEK = 2;

    case MONTH = 3;

    case YEAR = 4;

    case PERMANENT = 5;

    public function toString(): string
    {
        return match ($this) {
            self::DAY => 'Day',
            self::THREE_DAYS => '3 days',
            self::WEEK => 'Week',
            self::MONTH => 'Month',
            self::YEAR => 'Year',
            self::PERMANENT => 'Permanent'
        };
    }

    public function toDateTime(?string $format = null, bool $formatWithTimezone = true): Carbon|string|null
    {
        if ($this === self::PERMANENT) {
            return null;
        }

        $datetime = match ($this) {
            self::DAY => now()->addDay(),
            self::THREE_DAYS => now()->addDays(3),
            self::WEEK => now()->addWeek(),
            self::MONTH => now()->addMonth(),
            self::YEAR => now()->addYear(),
        };

        if (! $format) {
            return $datetime;
        }

        $result = $datetime->format($format);

        if ($formatWithTimezone) {
            $result .= ' ' . $datetime->getTimezone()->getName();
        }

        return $result;
    }
}
