<?php

namespace App\Observers;

use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use Illuminate\Support\Str;

class VacancyObserver
{
    public function creating(Vacancy $vacancy): void
    {
        if (! $vacancy->created_at) {
            $vacancy->created_at = now();
        }
    }

    public function saved(Vacancy $vacancy): void
    {
        Cache::forgetKey('vacancy', $vacancy->id);
        Cache::forgetKey('vacancies-published', $vacancy->employer()->first()?->employer_id);
    }

    public function deleted(Vacancy $vacancy): void
    {
        Cache::forgetKey('vacancy', $vacancy->id);
        Cache::forgetKey('vacancies-published', $vacancy->employer()->first()?->employer_id);
    }

}
