<?php

namespace App\Http\Controllers\Admin\Account;

use App\Actions\Admin\Account\GetAdminAccountInfoAction;
use App\Events\AdminUpdateEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAccountResetPasswordRequest;
use App\Http\Requests\Admin\AdminAccountUpdateRequest;
use App\Service\Admin\AccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    public function fetchAccountInfo(Request $request, GetAdminAccountInfoAction $action): JsonResponse
    {
        return response()->json($action->handle($request->user('admin')));
    }

    public function resetPassword(AdminAccountResetPasswordRequest $request, AccountService $accountService): JsonResponse
    {
        $accountService->resetPassword(
            admin: $request->user('admin'),
            currentPassword: $request->get('current_password'),
            newPassword: $request->get('new_password')
        );

        return response()->json(['redirect' => route('admin.logout')]);
    }

    public function updateAccountInfo(AdminAccountUpdateRequest $request, AccountService $accountService): JsonResponse
    {
        $accountDto = $request->getDto();

        $wasChanged = $accountService->updateName($request->user('admin'), $accountDto);

        if ($accountDto->getEmail() && $request->user('admin')->email !== $accountDto->getEmail()) {
            event(new AdminUpdateEmail(
                id: $request->user('admin')->admin_id,
                newEmail: $accountDto->getEmail())
            );

            return response()->json(['message' => 'All changes applied. We sent an email on your new address.']);
        }

        return $wasChanged
            ? response()->json(['message' => 'All changes was applied successfully.'])
            : response()->json(['message' => 'All is up-to-date']);
    }
}
