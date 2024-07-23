<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Persistence\Models\Employer;
use App\Service\Account\EmployerAccountService;
use App\Service\Employer\Storage\EmployerLogoService;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __construct(
        protected EmployerAccountService $accountService,
        protected EmployerLogoService $storageService
    ) {
    }

    public function index(): View
    {
        /**@var Employer $employer */
        $employer = $this->accountService->getEmpUserById(session('user.emp_id'));

        $logo = $this->storageService->getImageUrlByEmployer($employer);

        return view('employer.main', [
            'employer' => $employer,
            'logo' => $logo
        ]);
    }

}
