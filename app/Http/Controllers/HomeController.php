<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Service\Employer\Vacancy\VacancyService;
use App\View\ViewModels\VacancyViewModel;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

    public function __construct(
        private VacancyViewModel $viewModel,
        private VacancyService $vacancyService
    ) {
    }

    public function index(): View
    {
        phpinfo();
        $vacancies = $this->viewModel->getLatestPublishedVacancies(4);

        $vacancies = $this->vacancyService->overrideSkillsAndEmployerLogos($vacancies);

        $employersLogo = $this->vacancyService->getRandomEmployersLogoWhoHasVacancy(4);

        return view('home', ['vacancies' => $vacancies, 'logos' => $employersLogo]);
    }

}
