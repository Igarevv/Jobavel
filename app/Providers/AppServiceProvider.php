<?php

namespace App\Providers;

use App\Contracts\Storage\LogoStorageInterface;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Contracts\VerificationCodeRepositoryInterface;
use App\Persistence\Repositories\File\LocalFileStorage;
use App\Persistence\Repositories\File\S3FileStorage;
use App\Persistence\Repositories\User\UserRepository;
use App\Persistence\Repositories\User\VerificationCodeRepository;
use App\Persistence\Repositories\VacancyRepository;
use App\Service\Cache\Cache;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        UserRepositoryInterface::class => UserRepository::class,
        VacancyRepositoryInterface::class => VacancyRepository::class,
        VerificationCodeRepositoryInterface::class => VerificationCodeRepository::class
    ];

    public function register(): void
    {
        $this->bindFileStorage();

        $this->app->singleton(Cache::class, function (Application $app) {
            $cacheRepository = $app->make(Repository::class);

            return new Cache($cacheRepository);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }

    protected function bindFileStorage(): void
    {
        if (config('filesystems.provider') === 'file') {
            $this->app->singleton(LogoStorageInterface::class, LocalFileStorage::class);
        } elseif (config('filesystems.provider') === 's3') {
            $this->app->singleton(LogoStorageInterface::class, S3FileStorage::class);
        }
    }
}
