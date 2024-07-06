<?php

namespace App\Providers;

use App\Events\ContactEmailUpdatedEvent;
use App\Listeners\SendConfirmEmailAfterRegister;
use App\Listeners\SendVerificationCodeEmail;
use App\Listeners\SuccessfulLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendConfirmEmailAfterRegister::class,
        ],
        Login::class => [
            SuccessfulLogin::class,
        ],
        ContactEmailUpdatedEvent::class => [
            SendVerificationCodeEmail::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

}
