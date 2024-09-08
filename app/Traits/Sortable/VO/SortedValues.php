<?php

declare(strict_types=1);

namespace App\Traits\Sortable\VO;

class SortedValues
{

    private string $fieldName;

    private string $direction;

    public function __construct(
        string $field,
        string $direction
    ) {
        $this->fieldName = $field;

        $this->direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';
    }

    public static function fromRequest(string $fieldName, string $direction = 'desc'): static
    {
        return new static($fieldName, $direction);
    }

    public function field(): string
    {
        return $this->fieldName;
    }

    public function direction(): string
    {
        return $this->direction;
    }
}