<?php

namespace App\Listeners;

use App\Events\ContactEmailUpdatedEvent;
use App\Mail\VerificationCodeEmail;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ContactEmailUpdatedEvent $event): void
    {
        Mail::to($event->email)->send(new VerificationCodeEmail($event->code));
    }
}
