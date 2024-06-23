<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employee;

use App\DTO\Auth\RegisterEmployeeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRegisterRequest;
use App\Service\Auth\AuthService;
use App\Service\Auth\PasswordHasher;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{

    public function __construct(
        private readonly AuthService $authService,
        private readonly PasswordHasher $passwordHasher
    ) {}

    public function __invoke(EmployeeRegisterRequest $request
    ): RedirectResponse|View {
        if ($request->isMethod('GET')) {
            return view('employee.register');
        }

        $data = $request->validated();
        $employee = new RegisterEmployeeDto(
            firstName: $data['firstName'],
            lastName: $data['lastName'],
            email: $data['email'],
            password: $this->passwordHasher->hash($data['password'])
        );

        try {
            $this->authService->register($employee);
            return redirect()->route('login.show')->with(
                'register-success',
                'Registration completed successfully! You may login now'
            );
        } catch (\Exception $e) {
            return redirect()->route('employee.register')->with(
                'error',
                'An error occurred while processing the request. Please try again or contact to support'
            );
        }
    }

}
