<?php

namespace App\Persistence\Filters\Manual;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function apply(Builder $builder);
}