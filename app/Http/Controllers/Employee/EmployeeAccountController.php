<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeePersonalInfo;
use App\Service\Account\Employee\EmployeeAccountService;
use Illuminate\Http\RedirectResponse;

class EmployeeAccountController extends Controller
{

    public function __construct(
        private EmployeeAccountService $accountService
    ) {
    }

    public function update(EmployeePersonalInfo $request): RedirectResponse
    {
        $employeeUpdated = $this->accountService
            ->updatePersonalData(
                userId: session('user.emp_id'),
                employerDto: $request->getDto()
            );

        if (! $employeeUpdated) {
            return back()->with('nothing-updated', trans('alerts.employee-account.nothing-updated'));
        }

        $request->session()->put('user.name', $employeeUpdated->getFullName());

        return redirect()->action([HomeController::class, 'index'])->with(
            'success-updated',
            trans('alerts.employee-account.updated')
        );
    }
}
