<?php

namespace App\Actions\Admin\Account;

use App\Persistence\Models\Admin;

class GetAdminAccountInfoAction
{
    public function handle(Admin $admin): object
    {
        return (object) [
            'id' => $admin->admin_id,
            'email' => $admin->email,
            'firstName' => $admin->first_name,
            'lastName' => $admin->last_name,
            'status' => (object) [
                'name' => $admin->account_status?->toString(),
                'color' => $admin->account_status?->statusColor()
            ],
            'lastPasswordRest' => $admin->lastPasswordReset(),
            'createdAt' => $admin->created_at->format('Y-m-d H:i').' '.$admin->created_at->getTimezone()
        ];
    }
}
