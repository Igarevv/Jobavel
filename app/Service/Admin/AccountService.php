<?php

namespace App\Service\Admin;

use App\DTO\Admin\AdminAccountDto;
use App\Persistence\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    public function __construct(
        private FirstLoginService $firstLoginService
    ) {}

    public function resetPassword(Admin $admin, string $currentPassword, string $newPassword): void
    {
        $admin->update([
            'password' => Hash::make($newPassword, ['rounds' => 12]),
            'password_reset_at' => now(),
        ]);

        $this->firstLoginService->completeFirstLoginTrackingIfNeeded($admin);
    }

    public function updateName(Admin $admin, AdminAccountDto $accountDto): bool
    {
        $admin->update([
            'first_name' => $accountDto->getFirstName() ?? $admin->first_name,
            'last_name' => $accountDto->getLastName() ?? $admin->last_name,
        ]);

        return $admin->wasChanged();
    }

    public function updateEmail(Admin $admin, AdminAccountDto $accountDto): bool
    {
        $admin->update([
            'email' => $accountDto->getEmail()
        ]);

        return $admin->wasChanged();
    }
}
