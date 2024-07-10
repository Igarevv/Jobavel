<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Service\Account\EmployerAccountService;
use App\Service\Storage\LogoStorageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __construct(
        protected EmployerAccountService $accountService,
        protected LogoStorageService $storageService
    ) {
    }

    public function index(Request $request): View
    {
        $employer = $this->accountService->getUseById($request->session()
            ->get('user.emp_id'));

        $logo = $this->storageService
            ->getImageUrlByImageId($employer->company_logo, config('app.default_employer_logo'));

        return view('employer.main', [
            'employer' => $employer,
            'logo' => $logo
        ]);
    }

}
