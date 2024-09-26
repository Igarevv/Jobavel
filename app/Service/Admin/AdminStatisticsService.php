<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Enums\Admin\AdminStatisticsEnum;
use App\VO\DashboardStatistic;

final class AdminStatisticsService
{
    private DashboardStatistic $current;

    private DashboardStatistic $previous;

    private float|int $value;

    public function calculate(DashboardStatistic $current, DashboardStatistic $previous): AdminStatisticsService
    {
        $this->current = $current;

        $this->previous = $previous;

        $this->value = $current->calculatePercentageChange($previous);

        return $this;
    }

    public function getStatisticTypeEnum(): AdminStatisticsEnum
    {
        return $this->current->compareTo($this->previous);
    }

    public function getResult(): false|string
    {
        return $this->getStatisticTypeEnum()->formatResult($this->value);
    }

}
