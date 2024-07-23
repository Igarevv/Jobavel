<?php

declare(strict_types=1);

namespace App\Persistence\Filters\Pipeline\Vacancy;

use App\DTO\PipelineDto;
use App\Persistence\Filters\Pipeline\PipelineFilterInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class VacancyPipelineFilter implements PipelineFilterInterface
{
    public function __construct(
        private array $queryParams
    ) {
    }

    public function process(Builder $builder): Builder
    {
        /**@var Pipeline $pipe */
        $pipe = app(Pipeline::class);

        $builder = $pipe->send(new PipelineDto($builder, $this->queryParams))
            ->through([
                ConsiderWithoutExperienceFilter::class,
                EmploymentFilter::class,
                ExperienceFilter::class,
                LocationFilter::class,
                SalaryFilter::class,
                SkillsFilter::class
            ])
            ->via('apply')
            ->then(function (PipelineDto $pipeline) {
                return $pipeline->builder;
            });

        return $builder;
    }
}