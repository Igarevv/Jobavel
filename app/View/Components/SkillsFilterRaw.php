<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class SkillsFilterRaw extends Component
{

    public function __construct(
        public string $name,
        public array $skillSet
    ) {
    }

    public function isChecked(int $skillId, array $skillFromSession = []): bool
    {
        return in_array($skillId, $skillFromSession);
    }

    public function render(): View|Closure|string
    {
        return view('components.categories.skills-filter-raw');
    }
}
