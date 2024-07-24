<?php

declare(strict_types=1);

namespace App\View\ViewModels;

use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SkillsViewModel
{
    public function __construct(private Cache $cache)
    {
    }

    public function allSkills(): Collection
    {
        $cacheKey = $this->cache->getCacheKey('skills');

        return $this->cache->repository()->remember($cacheKey, CarbonInterval::year()->totalSeconds, function () {
            $categories = TechSkill::query()->orderBy('skill_name')
                ->toBase()
                ->get();

            $result = $categories->mapToGroups(function (object $techSkill) {
                $firstLetter = Str::upper(Str::substr($techSkill->skill_name, 0, 1));

                $skill = (object) [
                    'id' => $techSkill->id,
                    'skillName' => $techSkill->skill_name
                ];

                return [$firstLetter => $skill];
            });

            return $result->chunk(ceil($result->count() / 3));
        });
    }

    public function skillsAsRow(Collection $skills): string
    {
        return $skills->implode(function (\stdClass $skill) {
            return $skill->skillName;
        }, ' / ');
    }

    public function pluckExistingSkillsFromVacancy(Vacancy $vacancy): object
    {
        return (object) [
            'ids' => $vacancy->techSkill->pluck('id')->toArray(),
            'names' => $vacancy->techSkill->pluck('skill_name')->toArray(),
        ];
    }

}