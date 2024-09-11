<?php

namespace App\Observers;

use App\Persistence\Models\TechSkill;
use App\Service\Cache\Cache;

class TechSkillObserver
{
    public function saved(TechSkill $skill): void
    {
        Cache::forgetKey('skills');
    }

    public function created(TechSkill $skill): void
    {
        Cache::forgetKey('skills');
    }

    public function updated(TechSkill $skill): void
    {
        Cache::forgetKey('skills');
    }

    public function deleted(TechSkill $skill): void
    {
        Cache::forgetKey('skills');
    }
}
