<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\DTO\Auth\RegisterEmployerDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployerRegisterRequest;
use App\Service\Auth\AuthService;
use App\Service\Auth\PasswordHasher;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{

    public function __construct(
        private readonly AuthService $authService,
        private readonly PasswordHasher $passwordService
    ) {}

    public function __invoke(EmployerRegisterRequest $request
    ): RedirectResponse|View {
        if ($request->isMethod('GET')) {
            return view('employer.register');
        }

        $data = $request->validated();
        $employer = new RegisterEmployerDto(
            companyName: $data['company'],
            email: $data['email'],
            password: $this->passwordService->hash($data['password'])
        );

        try {
            $this->authService->register($employer);
            return redirect()->route('login.show')->with(
                'register-success',
                'Registration completed successfully! You may login now'
            );
        } catch (\Exception $e) {
            return redirect()->route('employer.register')->with(
                'error',
                'An error occurred while processing the request. Please try again or contact to support'
            );
        }
    }

}
