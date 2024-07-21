<?php

declare(strict_types=1);

namespace App\View\ViewModels;

use App\Persistence\Models\TechSkill;
use App\Persistence\Models\Vacancy;
use App\Service\Cache\Cache;
use Carbon\CarbonInterval;
use Illuminate\Support\Arr;
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

            $result = [];

            foreach ($categories as $category) {
                $firstLetter = Str::upper(Str::substr($category->skill_name, 0, 1));

                $skill = new \stdClass();
                $skill->id = $category->id;
                $skill->skillName = $category->skill_name;

                if (! Arr::exists($result, $firstLetter)) {
                    $result[$firstLetter] = [];
                }
                $result[$firstLetter][] = $skill;
            }

            return collect($result)->chunk(ceil(count($result) / 3));
        });
    }

    public function skillsAsRow(array $skills): string
    {
        return implode(' / ', array_map(fn($skill) => $skill->skillName, $skills));
    }

    public function pluckExistingSkillsFromVacancy(Vacancy $vacancy): object
    {
        return (object) [
            'ids' => $vacancy->pluck('id')->toArray(),
            'names' => $vacancy->pluck('skill_name')->toArray(),
        ];
    }

}