<?php

namespace App\Providers;

use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        UserRepositoryInterface::class => UserRepository::class,
    ];

    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

}
