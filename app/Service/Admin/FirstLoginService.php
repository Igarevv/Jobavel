<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Exceptions\AppException\TryToSignInWithTempPasswordSecondTime;
use App\Persistence\Contracts\AdminFirstLoginRepositoryInterface;
use App\Persistence\Models\Admin;

class FirstLoginService
{
    public function __construct(
        protected AdminFirstLoginRepositoryInterface $adminFirstLoginRepository
    ) {
    }

    /**
     * @throws TryToSignInWithTempPasswordSecondTime
     */
    public function handleAdminFirstLoginAttempt(Admin $admin): Admin
    {
        $firstLogin = $this->adminFirstLoginRepository->getAdminFirstLogin($admin);

        if (! $firstLogin) {
            return $admin;
        }

        if ($firstLogin->first_login_at !== null) {
            $this->deactivate($admin);

            throw new TryToSignInWithTempPasswordSecondTime();
        }

        $this->adminFirstLoginRepository->allowAdminMakeFirstLogin($admin);

        return $admin;
    }

    public function completeFirstLoginTrackingIfNeeded(Admin $admin): void
    {
        if (! $this->isFirstLogin($admin)) {
            return;
        }

        $this->adminFirstLoginRepository->deleteAdminFromFirstLogin($admin);

        $admin->activate();
    }

    protected function isFirstLogin(Admin $admin): bool
    {
        $firstLogin = $this->adminFirstLoginRepository->getAdminFirstLogin($admin);

        if ($firstLogin && $firstLogin->first_login_at !== null) {
            return true;
        }

        return false;
    }


    protected function deactivate(Admin $admin): void
    {
        $admin->deactivate();

        $this->adminFirstLoginRepository->deleteAdminFromFirstLogin($admin);
    }

}
