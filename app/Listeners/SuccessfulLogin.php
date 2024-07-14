<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class SuccessfulLogin
{

    public function handle(Login $event): void
    {
        $user = $event->user->getRelationByUserRole()->first();

        session([
            'user' => [
                'account_id' => $event->user->user_id,
                'emp_id' => $user->getEmpId(),
                'name' => $user->getFullName(),
                'role' => $event->user->getRole(),
            ],
        ]);
    }

}
