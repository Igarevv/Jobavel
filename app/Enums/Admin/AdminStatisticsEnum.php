<?php

namespace App\Enums\Admin;

use Illuminate\Support\Number;

enum AdminStatisticsEnum: int
{
    case MORE_THAN_WAS = 0;

    case LESS_THAN_WAS = 1;

    case NO_CHANGES = 2;

    public function toString(): string
    {
        return match ($this) {
            self::MORE_THAN_WAS => 'More then last month',
            self::LESS_THAN_WAS => 'Less then last month',
            self::NO_CHANGES => 'Same as last month'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MORE_THAN_WAS => 'text-green-500 dark:text-green-500',
            self::LESS_THAN_WAS => 'text-red-100 dark:text-red-100',
            self::NO_CHANGES => 'text-gray-500 dark:text-white'
        };
    }

    public function formatResult(float|int $percentage, int $precision = 1): false|string
    {
        if ($percentage === 0) {
            return $this->toString();
        }

        return Number::percentage($percentage, $precision);
    }
}
