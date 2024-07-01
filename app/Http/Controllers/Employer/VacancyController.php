<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacancyController extends Controller
{

    public function index()
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
        return view('employer.vacancy.list', ['jobInfo' => $jobInfo]);
    }

    public function create(): View
    {
        return view('employer.vacancy.create');
    }

    public function store(Request $request)
    {
        //
    }

}
