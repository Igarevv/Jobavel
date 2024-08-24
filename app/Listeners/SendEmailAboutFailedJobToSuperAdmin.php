<?php

namespace App\Listeners;

use App\Mail\FailedJobNotifierToSuperAdmin;
use App\Persistence\Models\Admin;
use Illuminate\Support\Facades\Mail;

class SendEmailAboutFailedJobToSuperAdmin
{

    public function __construct()
    {
        //
    }

    public function handle(object $event): void
    {
        $admin = Admin::query()->where('is_super_admin', true)
            ->firstOrFail('email');

        Mail::to($admin->email)->send(new FailedJobNotifierToSuperAdmin($event->exception));
    }
}
