<?php

namespace App\Listeners;

use App\Events\JobFailedInAdminPanel;
use App\Events\UserAccountRestored;
use App\Mail\RestoreAccountMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendEmailToUserWhoWantsToRestoreAccount implements ShouldQueue
{
    public $queue = 'low';

    public function handle(object $event): void
    {
        if ($event->user->trashed() && ! $event->user->hasVerifiedEmail()) {
            Mail::to($event->user->email)->send(new RestoreAccountMail($event->user));
        }
    }

    public function failed(UserAccountRestored $accountRestored, Throwable $throwable): void
    {
        event(new JobFailedInAdminPanel($throwable));
    }
}
