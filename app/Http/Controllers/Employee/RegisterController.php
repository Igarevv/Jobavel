<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\DTO\Auth\RegisterEmployeeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRegisterRequest;
use App\Service\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{

    public function __construct(
        private readonly AuthService $authService
    ) {
    }

    public function __invoke(EmployeeRegisterRequest $request): RedirectResponse|View
    {
        if ($request->isMethod('GET')) {
            return view('employee.register');
        }

        $employee = RegisterEmployeeDto::fromRequest($request);

        $this->authService->register($employee);

        return redirect()->route('login.show')->with(
            'register-success',
            trans('alerts.register.success')
        );
    }

}
