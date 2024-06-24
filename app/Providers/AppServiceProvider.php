<?php

namespace App\Providers;

use App\Dev;
use App\Persistance\Contracts\UserRepositoryInterface;
use App\Persistance\Repositories\UserRepository;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

}
