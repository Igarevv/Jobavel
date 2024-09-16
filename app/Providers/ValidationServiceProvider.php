<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Ramsey\Uuid\Uuid;

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

        Validator::extend('uuid_or_email', function ($attribute, $value, $parameters, $validator) {
            return Uuid::isValid($value ?? '') || filter_var($value, FILTER_VALIDATE_EMAIL);
        });
    }

}
