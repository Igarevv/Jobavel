<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\ViewModels\VacancyViewModel;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

    public function __construct(
        private VacancyViewModel $viewModel
    ) {
    }

    public function index(): View
    {
        $vacancies = $this->viewModel->getLatestPublishedVacancies(4);

        $employersLogo = $this->viewModel->getRandomEmployerLogos(4);

        return view('home', ['vacancies' => $vacancies, 'logos' => $employersLogo]);
    }

}
