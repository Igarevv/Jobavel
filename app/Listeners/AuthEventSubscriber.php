<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ContactEmailUpdatedEvent;
use App\Mail\ConfirmEmail;
use App\Mail\VerificationCodeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;

class AuthEventSubscriber implements ShouldQueue
{

    public $queue = 'high';

    public function handleEmployerUpdateContactEmail(ContactEmailUpdatedEvent $event): void
    {
        Mail::to($event->email)->send(new VerificationCodeEmail($event->code));
    }

    public function handleUserRegistered(Registered $event): void
    {
        if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            Mail::to($event->user)->send(new ConfirmEmail($event->user));
        }
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            Registered::class,
            [__CLASS__, 'handleUserRegistered']
        );

        $events->listen(
            ContactEmailUpdatedEvent::class,
            [__CLASS__, 'handleEmployerUpdateContactEmail']
        );
    }
}