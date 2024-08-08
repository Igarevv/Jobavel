<?php

declare(strict_types=1);

namespace App\Support;

class SlugVacancy
{
    public function __construct(
        private string $slug
    ) {
    }

    public function clearSlug(): int
    {
        $slug = explode('-', $this->slug);

        return (int)end($slug);
    }
}