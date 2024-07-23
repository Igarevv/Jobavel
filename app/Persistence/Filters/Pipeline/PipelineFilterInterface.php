<?php

namespace App\Persistence\Filters\Pipeline;

use Illuminate\Database\Eloquent\Builder;

interface PipelineFilterInterface
{
    public function process(Builder $builder): Builder;
}