<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Employer;
use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use App\Policies\ResumePolicy;
use App\Policies\RolesAndPermissionsPolicy;
use App\Policies\SkillsPolicy;
use App\Policies\VacancyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Vacancy::class => VacancyPolicy::class,
        Employee::class => ResumePolicy::class,
        Employer::class => ResumePolicy::class,
        Permission::class => RolesAndPermissionsPolicy::class,
        TechSkill::class => SkillsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }

}
