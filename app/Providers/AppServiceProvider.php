<?php

namespace App\Providers;

use App\Contracts\Storage\CvStorageInterface;
use App\Contracts\Storage\LogoStorageInterface;
use App\Http\Kernel;
use App\Persistence\Contracts\EmployerAccountRepositoryInterface;
use App\Persistence\Contracts\UserRepositoryInterface;
use App\Persistence\Contracts\VacancyRepositoryInterface;
use App\Persistence\Contracts\VerificationCodeRepositoryInterface;
use App\Persistence\Repositories\File\CV\LocalCvStorage;
use App\Persistence\Repositories\File\CV\S3CvStorage;
use App\Persistence\Repositories\File\Logo\LocalFileStorage;
use App\Persistence\Repositories\File\Logo\S3FileStorage;
use App\Persistence\Repositories\User\Employer\EmployerAccountRepository;
use App\Persistence\Repositories\User\Employer\VerificationCodeRepository;
use App\Persistence\Repositories\User\UserRepository;
use App\Persistence\Repositories\VacancyRepository;
use App\Service\Cache\Cache;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Spatie\Csp\AddCspHeaders;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        UserRepositoryInterface::class => UserRepository::class,
        VacancyRepositoryInterface::class => VacancyRepository::class,
        VerificationCodeRepositoryInterface::class => VerificationCodeRepository::class,
        EmployerAccountRepositoryInterface::class => EmployerAccountRepository::class
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
    public function boot(Kernel $kernel): void
    {
        if (! $this->app->hasDebugModeEnabled() || $this->app->isProduction()) {
            $kernel->prependMiddlewareToGroup('web', AddCspHeaders::class);
            $this->app->register('\Clockwork\Support\Laravel\ClockworkSupport::class');
        }

        Collection::macro('present', function (string $class) {
            return new $class($this);
        });

        Builder::macro('search', function (SearchDtoInterface $searchDto) {
            $model = $this->getModel();
            if (method_exists($model, 'search')) {
                return $model->search($this, $searchDto);
            }
            throw new \BadMethodCallException("Method search does not exist on model ".get_class($model));
        });
    }

    protected function bindFileStorage(): void
    {
        if (config('filesystems.provider') === 'file') {
            $this->app->singleton(LogoStorageInterface::class, LocalFileStorage::class);
            $this->app->singleton(CvStorageInterface::class, LocalCvStorage::class);
        } elseif (config('filesystems.provider') === 's3') {
            $this->app->singleton(CvStorageInterface::class, S3CvStorage::class);
            $this->app->singleton(LogoStorageInterface::class, S3FileStorage::class);
        }
    }
}
