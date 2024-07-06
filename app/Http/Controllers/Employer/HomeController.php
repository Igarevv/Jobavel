<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmployerRequest;
use App\Service\Account\EmployerAccountService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    public function update(UpdateEmployerRequest $request): RedirectResponse
    {
        $updatedData = $request->validated();

        $this->accountService->update($request->session()->get('user.emp_id'), $updatedData);

        if ($this->accountService->isEmailChangedAfterUpdate()) {
            return back()->with('email-updated-success', true);
        }
        
        return back()->with('updated-success', 'Your company data was successfully updated');
    }

}
