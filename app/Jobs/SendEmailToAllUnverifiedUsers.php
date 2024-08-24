<?php

namespace App\Jobs;

use App\Events\JobFailedInAdminPanel;
use App\Mail\NeedToVerifyEmailOrAccountWillDeleteMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendEmailToAllUnverifiedUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Collection $users,
    ) {
    }

    public function handle(): void
    {
        $users = $this->users->chunk(100);
        foreach ($users as $chunkedUsers) {
            foreach ($chunkedUsers as $user) {
                Mail::to($user->getEmailForVerification())->send(
                    new NeedToVerifyEmailOrAccountWillDeleteMail($user)
                );
            }
        }
    }

    public function failed(?Throwable $exception): void
    {
        event(new JobFailedInAdminPanel($exception));
    }

}
