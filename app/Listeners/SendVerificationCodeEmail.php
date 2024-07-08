<?php

namespace App\Listeners;

use App\Events\ContactEmailUpdatedEvent;
use App\Mail\VerificationCodeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendVerificationCodeEmail implements ShouldQueue
{
    public $queue = 'listeners';

    public function handle(ContactEmailUpdatedEvent $event): void
    {
        Mail::to($event->email)->send(new VerificationCodeEmail($event->code));
    }
}
