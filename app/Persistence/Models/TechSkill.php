<?php

namespace App\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechSkill extends Model
{

    use HasFactory;

    protected $fillable = [
        'skill_name',
    ];

}
