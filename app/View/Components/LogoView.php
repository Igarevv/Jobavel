<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LogoView extends Component
{
    public ?string $url;

    public ?string $alt;

    public int $imgColSize;

    public function __construct(?string $url, ?string $alt = null, int $imgColSize = 2)
    {
        $this->url = $url;

        $this->alt = $alt;

        $this->imgColSize = $imgColSize;
    }

    public function render(): View|Closure|string
    {
        return view('components.image.logo');
    }
}
