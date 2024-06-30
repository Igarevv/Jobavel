<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{

    public function list(): View
    {
        $jobInfo = (object)[
            'position' => 'Backend Laravel Developer',
            'company' => 'Google Inc.',
            'address' => 'New York',
            'salary' => '$2500',
            'image' => 'Adidas_Logo.jpg',
            'skills' => [
                'Laravel',
                'PHP',
                'PostgreSql',
                'Docker',
                'Git',
            ],
        ];
        $user = Auth::getSession()->get('user');
        return view('employer.vacancy.list', ['jobInfo' => $jobInfo]);
    }

}
