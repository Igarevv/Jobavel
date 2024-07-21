<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SkillsFilterView extends Component
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
        return view('components.categories.skills-filter');
    }
}
