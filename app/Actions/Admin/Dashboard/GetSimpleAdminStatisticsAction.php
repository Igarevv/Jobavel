<?php

declare(strict_types=1);

namespace App\Actions\Admin\Dashboard;

use App\Persistence\Models\AdminStatistics;
use App\Service\Admin\AdminStatisticsService;
use App\VO\DashboardStatistic;
use Carbon\Carbon;

class GetSimpleAdminStatisticsAction
{

    public function __construct(
        private AdminStatisticsService $statisticsService
    ) {}

    public function handle(): ?object
    {
        $currentMonthData = AdminStatistics::query()
            ->summarizeMonthlyStatistics([Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->first();

        $previousMonthData = AdminStatistics::query()
            ->summarizeMonthlyStatistics([
                Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()
            ])
            ->first();

        if (! $currentMonthData && ! $previousMonthData) {
            return null;
        }

        return $this->prepareData($currentMonthData, $previousMonthData);
    }

    private function prepareData(?AdminStatistics $current, ?AdminStatistics $previous): object
    {
        $statisticForVacancy = clone $this->statisticsService->calculate(
            current: new DashboardStatistic($current->vacancies_count ?? 0),
            previous: new DashboardStatistic($previous->vacancies_count ?? 0)
        );

        $statisticForEmployer = clone $this->statisticsService->calculate(
            current: new DashboardStatistic($current->employers_count ?? 0),
            previous: new DashboardStatistic($previous->employers_count ?? 0)
        );

        $statisticForEmployee = clone $this->statisticsService->calculate(
            current: new DashboardStatistic($current->employees_count ?? 0),
            previous: new DashboardStatistic($previous->employees_count ?? 0)
        );

        return (object)[
            'vacancies' => (object)[
                'value' => $statisticForVacancy->getResult(),
                'type' => $statisticForVacancy->getStatisticTypeEnum(),
            ],
            'employers' => (object)[
                'value' => $statisticForEmployer->getResult(),
                'type' => $statisticForEmployer->getStatisticTypeEnum(),
            ],
            'employees' => (object)[
                'value' => $statisticForEmployee->getResult(),
                'type' => $statisticForEmployee->getStatisticTypeEnum(),
            ],
        ];
    }

}
