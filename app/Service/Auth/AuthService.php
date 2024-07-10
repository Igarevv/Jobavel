<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Contracts\Auth\RegisterDtoInterface;
use App\Service\Auth\Registration\AuthFactory;
use Illuminate\Auth\Events\Registered;

readonly class AuthService
{

    public function __construct(
        private AuthFactory $registerFactory,
    ) {
    }

    public function register(RegisterDtoInterface $registerDto): void
    {
        $roleAuthService = $this->registerFactory->makeRegister(
            $registerDto->getRole()
        );

        $user = $roleAuthService->register($registerDto);

        event(new Registered($user));
    }

}
