<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployerRegisterRequest;
use App\Service\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{

    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function __invoke(EmployerRegisterRequest $request
    ): RedirectResponse|View {
        if ($request->isMethod('GET')) {
            return view('employer.register');
        }

        $employer = $this->authService->createEmployerRegisterDto(
            $request->validated()
        );

        try {
            $this->authService->register($employer);
            return redirect()->route('login.show')->with(
                'register-success',
                'Registration completed successfully! You may login now'
            );
        } catch (\Exception $e) {
            info($e->getMessage().'|'.$e->getLine());
            return redirect()->route('employer.register')->with(
                'error',
                'An error occurred while processing the request. Please try again or contact to support'
            );
        }
    }

}
