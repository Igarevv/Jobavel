<?php

namespace App\Listeners;

use App\Persistence\Models\Admin;

class SuccessfulAdminLogin
{
    public function handle(object $event): void
    {
        if ($event->user instanceof Admin) {
            session([
                'user' => [
                    'user_id' => $event->user->admin_id,
                    'name' => $event->user->getFullName(),
                    'role' => Admin::ADMIN,
                    'acc_status' => $event->user->account_status?->toString()
                ],
            ]);
        }
    }
}
