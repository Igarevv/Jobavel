<?php

declare(strict_types=1);

namespace App\Service\Employer\Vacancy;

use App\Persistence\Models\TechSkill;
use App\Service\Cache\Cache;
use Carbon\CarbonInterval;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TechSkillService
{
    public function __construct(
        protected Cache $cache
    ) {
    }

    public function getSkillCategories(): Collection
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
}