<?php

declare(strict_types=1);

namespace App\Service\Employer\Vacancy;

use App\Enums\Vacancy\VacancyStatusEnum;
use App\Persistence\Models\Employer;

class EmployerVacancyService
{
    public function unpublishAllVacanciesForEmployer(Employer $employer): void
    {
        $employer->vacancies()->update(['status' => VacancyStatusEnum::TRASHED->value]);
    }
}
