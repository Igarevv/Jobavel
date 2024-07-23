<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Database\Eloquent\Builder;

readonly class PipelineDto
{
    public function __construct(
        public Builder $builder,
        public array $queryParams
    ) {
    }
}