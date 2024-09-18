<?php

namespace App\Policies;

use App\Persistence\Models\Admin;
use App\Persistence\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    use HandlesAuthorization;

    public function viewModerate(Admin $admin, Vacancy $vacancy): Response
    {
        if (! $vacancy->isInModeration()) {
            return Response::denyAsNotFound(code: 404);
        }

        if ($admin->hasPermissionTo('vacancy-moderate') || $admin->isSuperAdmin()) {
            return Response::allow();
        }

        return Response::denyAsNotFound(code: 404);
    }
}
