<?php

namespace App\Listeners;

use App\Mail\UserDeletedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailWhenUserDeleted implements ShouldQueue
{

    public $queue = 'low';

    public function __construct()
    {
    }

    public function handle(object $event): void
    {
        Mail::to($event->email)->send(new UserDeletedMail());
    }
}
