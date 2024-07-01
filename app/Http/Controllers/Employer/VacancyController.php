<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Persistence\Models\TechSkill;
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
        $categories = TechSkill::query()->orderBy('skill_name')
            ->toBase()
            ->get();
        return view('employer.vacancy.create', ['skills' => $categories]);
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

}
