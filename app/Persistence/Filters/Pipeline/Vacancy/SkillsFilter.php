<?php

declare(strict_types=1);

namespace App\Persistence\Filters\Pipeline\Vacancy;

use App\DTO\PipelineDto;
use App\Persistence\Filters\Pipeline\PipeFilterInterface;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class SkillsFilter implements PipeFilterInterface
{

    public function apply(PipelineDto $pipeline, Closure $next)
    {
        $param = $pipeline->queryParams[$this->getParamKey()] ?? null;

        $pipeline->builder->when($param, function (Builder $builder) use ($param) {
            $builder->whereHas('techSkill', function (Builder $builder) use ($param) {
                $builder->whereIn('tech_skill_id', $param);
            });
        });

        return $next($pipeline);
    }

    public function getParamKey(): string
    {
        return 'skills';
    }
}