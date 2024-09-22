<?php

namespace App\Listeners;

use App\Events\JobFailedInAdminPanel;
use App\Events\NewAdminCreated;
use App\Mail\NewAdminCredentialsToLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendEmailToNewAdminWithTempPassword implements ShouldQueue
{
    public $queue = 'low';

    public function handle(object $event): void
    {
        Mail::to($event->admin->email)->send(new NewAdminCredentialsToLogin($event->admin, $event->tempPassword));
    }

    public function failed(NewAdminCreated $adminCreated, Throwable $throwable): void
    {
        event(new JobFailedInAdminPanel($throwable));
    }
}
