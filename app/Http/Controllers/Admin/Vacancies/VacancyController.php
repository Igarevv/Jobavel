<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Vacancies;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\EmployerVacancies;
use App\Persistence\Models\Employer;
use App\View\ViewModels\VacancyViewModel;

class VacancyController extends Controller
{
    public function employerVacancies(Employer $employer, VacancyViewModel $vacancyViewModel): EmployerVacancies
    {
        $vacancies = $vacancyViewModel->getAllVacanciesRelatedToEmployer($employer, [
            'id',
            'slug',
            'title',
            'location',
            'employment_type',
            'published_at',
            'response_number',
            'created_at',
        ]);

        return new EmployerVacancies($vacancies);
    }
}