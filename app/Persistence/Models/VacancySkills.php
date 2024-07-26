<?php

declare(strict_types=1);

namespace App\Persistence\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VacancySkills extends Pivot
{
    protected $table = 'tech_skill_vacancy';
}