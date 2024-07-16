<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoriesView extends Component
{
    public function __construct(
        public string $name,
        public array $skillSet,
        public ?object $existingSkills = null
    ) {
    }

    public function isChecked(int $skillId, array $skillFromSession = []): bool
    {
        return in_array($skillId, $skillFromSession) || in_array($skillId, $this->existingSkills?->ids ?? []);
    }

    public function render(): View|Closure|string
    {
        return view('components.categories.list');
    }
}
