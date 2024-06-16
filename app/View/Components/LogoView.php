<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class LogoView extends Component
{
    public ?string $filename;

    public function __construct(?string $filename = null)
    {
        if (! trim($filename) || ! Storage::disk('public')->exists('logo/'.$filename)){
            $this->filename = 'default_logo.png';
        } else {
            $this->filename = $filename;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.image.logo');
    }
}
