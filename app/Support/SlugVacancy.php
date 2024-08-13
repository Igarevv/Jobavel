<?php

declare(strict_types=1);

namespace App\Support;

use App\Persistence\Models\Vacancy;

class SlugVacancy
{
    public function __construct(
        private string $slug
    ) {
    }

    public function createFromSlug(...$columns): Vacancy
    {
        if (! $columns) {
            $columns = ['*'];
        }

        return Vacancy::findOrFail($this->getIdFromSlug(), $columns);
    }

    public function getIdFromSlug(): int
    {
        $slug = explode('-', $this->slug);

        return (int)end($slug);
    }

    public function getOriginalSlug(): string
    {
        return $this->slug;
    }

}