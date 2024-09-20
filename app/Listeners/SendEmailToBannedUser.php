<?php

namespace App\Listeners;

use App\Mail\UserBannedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailToBannedUser implements ShouldQueue
{

    public $queue = 'low';

    public function handle(object $event): void
    {
        $user = $event->actionDto->getActionableModel()->user;

        Mail::to($user->getEmail())->send(new UserBannedMail($event->actionDto, $event->bannedUntil));
    }
}
