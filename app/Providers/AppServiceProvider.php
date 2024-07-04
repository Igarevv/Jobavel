<?php

namespace App\Providers;

use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Repositories\UserRepository;
use App\Persistence\Repositories\VacancyRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        UserRepositoryInterface::class => UserRepository::class,
        VacancyRepositoryInterface::class => VacancyRepository::class,
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
