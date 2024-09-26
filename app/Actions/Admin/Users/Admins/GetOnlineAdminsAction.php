<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Admins;

use App\Persistence\Models\Admin;
use App\Service\Cache\Cache;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Collection;

class GetOnlineAdminsAction
{

    public function __construct(
        private Cache $cache
    ) {}

    public function handle(): Collection
    {
        $admins = Admin::query()
            ->activeAdmins()
            ->get(['id', 'first_name', 'last_name', 'email', 'admin_id']);

        return $this->prepareData($admins);
    }

    public function prepareData(ECollection $admins): Collection
    {
        return $admins->map(function (Admin $admin) {
            return (object)[
                'id' => $admin->id,
                'name' => $admin->getFullName(),
                'email' => $admin->email,
                'isOnline' => $this->cache->repository()->has('online-a-'.$admin->getAdminId()),
            ];
        });
    }

}
