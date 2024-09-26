<?php

namespace App\Console\Commands;

use App\Persistence\Models\AdminStatistics;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Employer;
use App\Persistence\Models\Vacancy;
use Illuminate\Console\Command;

class CollectStatisticsForAdminDash extends Command
{
    protected $signature = 'admin:statistics-dash';

    protected $description = 'Command collect statistics for admin dash';

    public function handle(): void
    {
        AdminStatistics::query()->create([
            'vacancies_count' => Vacancy::query()->published()->count(),
            'employers_count' => Employer::query()->count(),
            'employees_count' => Employee::query()->count(),
            'record_at' => now()
        ]);
    }
}
