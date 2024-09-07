<?php

declare(strict_types=1);

namespace App\DTO\Admin;

final class AdminSortDto
{
    public function __construct(
        private string $column,
        private string $direction
    ) {
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

}