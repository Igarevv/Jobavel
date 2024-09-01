<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Exceptions\TryToSignInWithTempPasswordSecondTime;
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
            $this->deactivate($admin, $firstLogin);
        }

        $this->adminFirstLoginRepository->allowAdminMakeFirstLogin($firstLogin->id);

        return $admin;
    }

    protected function deactivate(Admin $admin, object $firstLoginData): void
    {
        $admin->deactivate();

        $this->adminFirstLoginRepository->deleteAdminFromFirstLogin($firstLoginData->id);

        throw new TryToSignInWithTempPasswordSecondTime();
    }

}