<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Service\Account\EmployerAccountService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function __construct(
        protected EmployerAccountService $accountService
    ) {
    }

    public function index(Request $request): View
    {
        $employer = $this->accountService->getUseById($request->session()
            ->get('user.emp_id'));

        return view('employer.main', [
            'employer' => $employer,
        ]);
    }

}
