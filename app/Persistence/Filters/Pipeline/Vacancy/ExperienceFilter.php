<?php

declare(strict_types=1);

namespace App\Persistence\Filters\Pipeline\Vacancy;

use App\DTO\PipelineDto;
use App\Persistence\Filters\Pipeline\PipeFilterInterface;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class ExperienceFilter implements PipeFilterInterface
{

    public function apply(PipelineDto $pipeline, Closure $next)
    {
        $param = $pipeline->queryParams[$this->getParamKey()] ?? null;

        $condition = is_array($param) && (($param['years'] === 1 || $param['years'] === 0) && $param['consider']);

        $pipeline->builder->when($condition, function (Builder $builder) use ($param) {
            $builder->where(function (Builder $builder) use ($param) {
                $builder->where('experience_time', $param['years'])
                    ->where('consider_without_experience', true);
            });
        }, function (Builder $builder) use ($param) {
            $builder->when($param, function (Builder $builder) use ($param) {
                $builder->where('experience_time', $param);
            });
        });

        return $next($pipeline);
    }

    public function getParamKey(): string
    {
        return 'experience';
    }
}