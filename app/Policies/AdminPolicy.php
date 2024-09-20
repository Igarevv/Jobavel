<?php

namespace App\Policies;

use App\Persistence\Models\Admin;
use App\Persistence\Models\User;
use App\Persistence\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    use HandlesAuthorization;

    public function moderate(Admin $admin, Vacancy $vacancy): Response
    {
        if (! $vacancy->isInModeration() && $vacancy->isApproved()) {
            return Response::denyAsNotFound(code: 404);
        }

        if ($admin->isSuperAdmin()) {
            return Response::allow();
        }

        if (! $admin->hasPermissionTo('vacancy-moderate')) {
            return Response::deny('Only super admin and permitted admin can have access to moderation');
        }

        return Response::allow();
    }

    public function viewActionsInfo(Admin|User|null $user, Vacancy $vacancy): Response
    {
        if ($user instanceof User && $user?->employer->id === $vacancy->employer_id) {
            return Response::allow();
        }

        if ($user instanceof Admin && ($user->hasPermissionTo('vacancy-moderate') || $user->isSuperAdmin())) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }
}
