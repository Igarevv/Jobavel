<?php

declare(strict_types=1);

namespace App\View\ViewModels;

use App\Persistence\Models\Employer;
use App\Persistence\Models\VacancySkills;
use Illuminate\Support\Collection;

class EmployerViewModel
{
    public function prepareStatistics(Employer $employer): ?object
    {
        $topSkills = $employer->topFrequentlySelectedSkills(3) ?: null;

        if ($topSkills) {
            $topSkills = (object)[
                'ids' => $this->skillIdsInRaw($topSkills),
                'names' => $this->skillNamesInRaw($topSkills)
            ];
        }

        [$today, $month] = $employer->appliedVacanciesForTodayAndMonth();

        return (object)[
            'totalVacancies' => $employer->vacancies()->count(),
            'skills' => $topSkills,
            'today' => $today,
            'month' => $month
        ];
    }

    protected function skillIdsInRaw(Collection $vacancySkills): string
    {
        return $vacancySkills->implode(function (VacancySkills $vacancySkills) {
            return $vacancySkills->id;
        }, ',');
    }

    protected function skillNamesInRaw(Collection $vacancySkills): string
    {
        return $vacancySkills->implode(function (VacancySkills $vacancySkills) {
            return $vacancySkills->skill_name;
        }, ', ');
    }

}
