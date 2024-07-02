<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRegisterRequest;
use App\Service\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{

    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function __invoke(EmployeeRegisterRequest $request
    ): RedirectResponse|View {
        if ($request->isMethod('GET')) {
            return view('employee.register');
        }

        $employee = $this->authService->createEmployeeRegisterDto(
            $request->validated()
        );

        $this->authService->register($employee);

        return redirect()->route('login.show')->with(
            'register-success',
            trans('alerts.register.success')
        );
    }

}
