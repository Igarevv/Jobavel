<?php

declare(strict_types=1);

namespace App\Traits\Sortable;

use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Database\Eloquent\Builder;

trait Sortable
{

    public function scopeSortBy(Builder $builder, SortedValues $sortedValues): Builder
    {
        try {
            $column = $this->fromAliases($sortedValues->field());

            $parts = collect(explode(',', trim($column)))
                ->map(fn($part) => $part.' '.$sortedValues->direction())
                ->implode(',');

            return $builder->orderByRaw($parts);
        } catch (\InvalidArgumentException $e) {
            return $builder;
        }
    }

    private function fromAliases(string $fieldAlias): string
    {
        $fields = $this->sortableFields();

        if (array_key_exists($fieldAlias, $fields)) {
            return $fields[$fieldAlias];
        }

        if (in_array($fieldAlias, $fields, true)) {
            return $fieldAlias;
        }

        throw new \InvalidArgumentException("Field {$fieldAlias} not exists. Check your sortableFields() method");
    }

    abstract protected function sortableFields(): array;
}
