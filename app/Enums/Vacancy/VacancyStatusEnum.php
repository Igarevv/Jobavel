<?php

namespace App\Enums\Vacancy;

enum VacancyStatusEnum: int
{
    case IN_MODERATION = 0;

    case PUBLISHED = 1;

    case TRASHED = 2;

    case NOT_APPROVED = 3;

    case NOT_PUBLISHED = 4;

    case APPROVED = 5;

    public function toString(): string
    {
        return match ($this) {
            self::IN_MODERATION => 'In moderation',
            self::PUBLISHED => 'Published',
            self::TRASHED => 'Removed to trash',
            self::NOT_APPROVED => 'Not approved',
            self::NOT_PUBLISHED => 'Not published',
            self::APPROVED => 'Approved'
        };
    }

    public function colorBootstrap(): string
    {
        return match ($this) {
            self::IN_MODERATION => 'status-info',
            self::PUBLISHED => 'status-success',
            self::NOT_APPROVED => 'status-danger',
            self::TRASHED => 'status-secondary',
            self::NOT_PUBLISHED => 'status-warning',
            self::APPROVED => 'status-light color-green',
        };
    }

    public function colorTailwind(): string
    {
        return match ($this) {
            self::IN_MODERATION => 'bg-custom-cyan-400 text-white',
            self::PUBLISHED => 'bg-custom-lime-400 text-white',
            self::NOT_APPROVED => 'bg-custom-red text-white',
            self::TRASHED => 'bg-custom-stone-500 text-white',
            self::NOT_PUBLISHED => 'bg-custom-yellow-500 text-white',
            self::APPROVED => 'bg-custom-green-50 text-green-500'
        };
    }
}
