<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Contracts\RegisterDtoInterface;
use App\Service\Auth\Registration\RegisterFactory;

class AuthService
{

    public function __construct(
        private readonly RegisterFactory $registerFactory
    ) {}

    public function register(RegisterDtoInterface $registerDto): void
    {
        $roleAuthService = $this->registerFactory->make($registerDto->role);

        $roleAuthService->register($registerDto);
    }

}
