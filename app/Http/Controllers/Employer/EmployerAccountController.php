<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Exceptions\InvalidVerificationCodeException;
use App\Exceptions\VerificationCodeTimeExpiredException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmployerRequest;
use App\Service\Account\EmployerAccountService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmployerAccountController extends Controller
{
    public function __construct(
        protected EmployerAccountService $accountService
    ) {
    }

    public function update(UpdateEmployerRequest $request): RedirectResponse
    {
        $updatedData = $request->validated();

        $this->accountService->update($request->session()->get('user.emp_id'), $updatedData);

        if ($this->accountService->isEmailChangedAfterUpdate()) {
            $request->session()->put('frontend.show-button-for-modal', true);

            return back()->with('frontend.email-updated-success', true);
        }

        return back()->with('updated-success', trans('alerts.employer-account.updated'));
    }

    public function verifyContactEmail(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'code' => 'required|digits:6'
        ]);

        $userId = $request->session()->get('user.emp_id');

        try {
            $this->accountService->verifyCodeFromRequest((int) $input['code'], $userId);

            $request->session()->forget('frontend.show-button-for-modal');
        } catch (VerificationCodeTimeExpiredException|InvalidVerificationCodeException $e) {
            return back()->with('frontend.code-expired', $e->getMessage());
        }

        return back()->with('verification-success', trans('alerts.employer-account.email-verified'));
    }

}