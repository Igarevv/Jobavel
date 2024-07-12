<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Exceptions\InvalidVerificationCodeException;
use App\Exceptions\VerificationCodeTimeExpiredException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmployerRequest;
use App\Service\Account\CodeVerificationService;
use App\Service\Account\EmployerAccountService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmployerAccountController extends Controller
{
    public function __construct(
        protected EmployerAccountService $accountService,
        protected CodeVerificationService $verificationService
    ) {
    }

    public function update(UpdateEmployerRequest $request): RedirectResponse
    {
        $updatedData = $request->validated();
        
        $employer = $this->accountService->update(session('user.emp_id'), $updatedData, $this->verificationService);

        $request->session()->put('user.name', $employer->company_name);

        if ($this->accountService->isNewContactEmail()) {
            $request->session()->put('frontend.show-button-for-modal', true);

            return back()->with('frontend.email-want-update', true);
        }

        return back()->with('updated-success', trans('alerts.employer-account.updated'));
    }

    public function verifyContactEmail(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'code' => 'required|digits:6'
        ]);

        $userId = session('user.emp_id');

        try {
            $this->verificationService->verifyCodeFromRequest((int) $input['code'], $userId);

            $request->session()->forget('frontend.show-button-for-modal');
        } catch (VerificationCodeTimeExpiredException|InvalidVerificationCodeException $e) {
            return back()->with('frontend.code-expired', $e->getMessage());
        }

        return back()->with('verification-success', trans('alerts.employer-account.email-verified'));
    }

    public function resendCode(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->verificationService->resendEmail(session('user.emp_id'));

        $request->session()->put('frontend.show-button-for-modal', true);

        return response()->json(['status' => 200]);
    }

}