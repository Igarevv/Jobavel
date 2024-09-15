<?php

namespace App\Listeners;

use App\Mail\ConfirmAdminEmailChanging;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToAdminToConfirmEmailChange implements ShouldQueue
{
    public $queue = 'low';

    public function handle(object $event): void
    {
        Mail::to($event->newEmail)->send(new ConfirmAdminEmailChanging($event->id, $event->newEmail));
    }
}
