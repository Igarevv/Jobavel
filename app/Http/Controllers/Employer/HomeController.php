<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Persistence\Models\Employer;
use App\Service\Employer\Storage\EmployerLogoService;
use App\View\ViewModels\EmployerViewModel;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __construct(
        protected EmployerLogoService $employerLogoService,
        protected EmployerViewModel $employerViewModel
    ) {
    }

    public function index(): View
    {
        $employer = Employer::findByUuid(session('user.emp_id'));

        $statistics = $this->employerViewModel->prepareStatistics($employer);

        $logo = $this->employerLogoService->getImageUrlByEmployer($employer);

        return view('employer.main', [
            'employer' => $employer,
            'logo' => $logo,
            'statistics' => $statistics
        ]);
    }

}
