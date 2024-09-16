<?php

namespace App\Actions\Admin\Users\Admins;

use App\Persistence\Models\Admin;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetAdminsPaginatedAction
{
    public function handle(SortedValues $sortedValues): LengthAwarePaginator
    {
        $admins = Admin::query()
            ->withoutSuperAdmins()
            ->sortBy($sortedValues)
            ->paginate(5, [
                'admin_id',
                'last_name',
                'first_name',
                'email',
                'account_status',
                'created_at',
            ]);

        return $this->prepareData($admins);
    }

    private function prepareData(LengthAwarePaginator $admins): LengthAwarePaginator
    {
        return $admins->through(function (Admin $admin) {
            return (object) [
                'id' => $admin->admin_id,
                'idEncrypted' => Str::mask($admin->admin_id, '*', 5, -2),
                'email' => $admin->email,
                'name' => $admin->getFullName(),
                'status' => $admin->account_status->toString(),
                'createdAt' => $admin->created_at->format('Y-m-d H:i').' '.$admin->created_at->getTimezone()
            ];
        });
    }
}
