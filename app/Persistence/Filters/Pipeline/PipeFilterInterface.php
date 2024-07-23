<?php

namespace App\Persistence\Filters\Pipeline;

use App\DTO\PipelineDto;
use Closure;

interface PipeFilterInterface
{
    public function apply(PipelineDto $pipeline, Closure $next);

    public function getParamKey(): string;
}