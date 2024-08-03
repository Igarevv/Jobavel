<?php

namespace App\Persistence\Models;

use App\Service\Cache\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TechSkill extends Model
{

    use HasFactory;

    protected $fillable = [
        'skill_name',
    ];

    public function vacancies(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (TechSkill $skill) {
            Cache::forgetKey('skills');
        });
    }
}
