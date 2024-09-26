<?php

declare(strict_types=1);

namespace App\VO;

use App\Enums\Admin\AdminStatisticsEnum;

class DashboardStatistic
{
    public function __construct(private int $count) {}

    public function getCount(): int
    {
        return $this->count;
    }

    public function compareTo(DashboardStatistic $previous): AdminStatisticsEnum
    {
        if ($this->count === $previous->getCount()) {
            return AdminStatisticsEnum::NO_CHANGES;
        }

        if ($previous->getCount() === 0) {
            return AdminStatisticsEnum::MORE_THAN_WAS;
        }

        return $this->count > $previous->getCount()
            ? AdminStatisticsEnum::MORE_THAN_WAS
            : AdminStatisticsEnum::LESS_THAN_WAS;
    }

    public function calculatePercentageChange(DashboardStatistic $previous): float|int
    {
        if ($previous->getCount() === 0) {
            return 100;
        }

        return (($this->count - $previous->getCount()) / $previous->getCount()) * 100;
    }
}
