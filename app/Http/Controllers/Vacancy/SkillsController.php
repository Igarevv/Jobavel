<?php

declare(strict_types=1);

namespace App\Http\Controllers\Vacancy;

use App\Http\Controllers\Controller;
use App\View\ViewModels\SkillsViewModel;
use Illuminate\Http\JsonResponse;

class SkillsController extends Controller
{

    public function getAllSkills(SkillsViewModel $skillsViewModel): JsonResponse
    {
        $skills = $skillsViewModel->allSkills();
        
        return response()->json($skills);
    }
}