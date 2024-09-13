<?php

namespace App\Service\Admin;

use App\Persistence\Models\Admin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    public function __construct(
        private FirstLoginService $firstLoginService
    ) {}

    public function resetPassword(Admin $admin, string $currentPassword, string $newPassword): void
    {
        if (! Hash::check($currentPassword, $admin->password)) {
            throw new AuthorizationException('Your current password is incorrect');
        }

        $admin->update([
            'password' => Hash::make($newPassword, ['rounds' => 12]),
            'password_reset_at' => now()
        ]);

        $this->firstLoginService->completeFirstLoginTrackingIfNeeded($admin);
    }
}
