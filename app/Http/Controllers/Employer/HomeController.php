<?php

declare(strict_types=1);

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{

    public function index(): View
    {
        return view('employer.main');
    }

}
