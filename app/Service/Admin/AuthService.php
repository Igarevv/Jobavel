<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\DTO\Auth\AdminRegisterDto;
use App\Events\NewAdminCreated;
use App\Exceptions\TryToSignInWithTempPasswordSecondTime;
use App\Persistence\Contracts\AdminAuthRepositoryInterface;
use App\Persistence\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function __construct(
        protected AdminAuthRepositoryInterface $adminAuthRepository,
        protected FirstLoginService $firstLoginService
    ) {
    }

    public function register(AdminRegisterDto $adminRegisterDto): void
    {
        $tempPassword = Str::random();

        $admin = $this->adminAuthRepository->save($adminRegisterDto, $tempPassword);

        event(new NewAdminCreated($admin, $tempPassword));
    }

    /**
     * @throws TryToSignInWithTempPasswordSecondTime
     */
    public function prepareToLogin(object $loginData): Admin
    {
        $admin = $this->adminAuthRepository->getByEmail($loginData->email);

        if (! $admin || ! Hash::check($loginData->password, $admin->password)) {
            throw new ModelNotFoundException();
        }

        return $this->firstLoginService->handleAdminFirstLoginAttempt($admin);
    }

}