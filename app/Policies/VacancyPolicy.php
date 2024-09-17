<?php

namespace App\Policies;

use App\Persistence\Models\Admin;
use App\Persistence\Models\User;
use App\Persistence\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VacancyPolicy
{
    use HandlesAuthorization;

    public function before(Admin|User|null $user, string $ability): ?true
    {
        if ($user instanceof Admin) {
            return true;
        }

        return null;
    }

    public function create(?User $user): bool
    {
        return $user?->hasPermissionTo('vacancy-create');
    }

    public function edit(?User $user, Vacancy $vacancy): Response
    {
        return $this->checkPermission($user, $vacancy, 'vacancy-edit');
    }

    public function apply(?User $user): bool
    {
        return (bool)$user?->hasPermissionTo('vacancy-apply');
    }

    public function viewAny(?User $user, Vacancy $vacancy): Response
    {
        if ($vacancy->is_published) {
            return Response::allow();
        }

        return $this->checkPermission($user, $vacancy, 'vacancy-view');
    }

    public function view(?User $user, Vacancy $vacancy): Response
    {
        return $this->checkPermission($user, $vacancy, 'vacancy-view');
    }

    public function publish(?User $user, Vacancy $vacancy): Response
    {
        return $this->checkPermission($user, $vacancy, 'vacancy-publish');
    }

    public function delete(?User $user, Vacancy $vacancy): Response
    {
        return $this->checkPermission($user, $vacancy, 'vacancy-delete');
    }

    private function checkPermission(?User $user, Vacancy $vacancy, string $permission): Response
    {
        return $user?->hasPermissionTo($permission) && $user?->employer->id === $vacancy->employer_id
            ? Response::allow()
            : Response::denyAsNotFound(code: 404);
    }
}

//TODO: может сделать так чтобы админы могли снимать публикацию с вакансии и давать в первое время какой то бан на публикации вакансий
//TODO: ну и само собой как то остлеживать ранее забаненых временно людей и если они несколько раз банились то давать перманент
//TODO: подумай что еще админ может делать по отношению к работодателю и работнику
