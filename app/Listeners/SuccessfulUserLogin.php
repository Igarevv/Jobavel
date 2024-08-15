<?php

namespace App\Listeners;

use App\Persistence\Models\User;
use Illuminate\Auth\Events\Login;

class SuccessfulUserLogin
{

    public function handle(Login $event): void
    {
        if ($event->user instanceof User) {
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

}
