<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class SuccessfulLogin
{

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = DB::table('user_login_data')->where(
            'email',
            $event->user->email
        )->first();

        session([
            'user' => [
                'account_id' => $user->account_id,
                'emp_id' => $user->user_id,
                'name' => $user->name,
                'role' => $user->role,
            ],
        ]);
    }

}
