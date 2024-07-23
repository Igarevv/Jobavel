<?php

declare(strict_types=1);

namespace App\Persistence\Filters\Pipeline\Vacancy;

use App\DTO\PipelineDto;
use App\Persistence\Filters\Pipeline\PipeFilterInterface;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class ConsiderWithoutExperienceFilter implements PipeFilterInterface
{

    public function apply(PipelineDto $pipeline, Closure $next)
    {
        $pipeline->builder->when($pipeline->queryParams[$this->getParamKey()] ?? null, function (Builder $builder) {
            $builder->where('consider_without_experience', true);
        });

        return $next($pipeline);
    }

    public function getParamKey(): string
    {
        return 'consider';
    }
}