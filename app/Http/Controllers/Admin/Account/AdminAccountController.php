<?php

namespace App\Http\Controllers\Admin\Account;

use App\Actions\Admin\Account\GetAdminAccountInfoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminAccountResetPasswordRequest;
use App\Service\Admin\AccountService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    public function fetchAccountInfo(Request $request, GetAdminAccountInfoAction $action): JsonResponse
    {
        return response()->json($action->handle($request->user('admin')));
    }

    public function resetPassword(AdminAccountResetPasswordRequest $request, AccountService $accountService)
    {
        try {
            $accountService->resetPassword(
                admin: $request->user('admin'),
                currentPassword: $request->get('current_password'),
                newPassword: $request->get('new_password')
            );
        } catch (AuthorizationException $e) {
            return response()->json(['errors' => [
                [$e->getMessage()]
            ]]);
        }

        return response()->json(['redirect' => route('admin.logout')]);
    }
}
