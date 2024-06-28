<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class ValidationServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            $rule = Password::min(8);

            /** @var \Illuminate\Foundation\Application $app */
            $app = $this->app;

            return $app->isProduction() ?
                $rule->mixedCase()->uncompromised()
                : $rule;
        });
    }

}
