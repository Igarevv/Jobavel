<?php

namespace App\Persistence\Models;

use App\Service\Cache\Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int employer_id
 * @property string title
 * @property int $salary
 * @property string $description
 * @property string $location
 * @property array $requirements,
 * @property array $responsibilities
 * @property array $offers
 * @property bool $is_published
 * @property int $response_number
 * @property Carbon $created_at
 */
class Vacancy extends Model
{

    use HasFactory;

    protected $casts = [
        'requirements' => 'array',
        'responsibilities' => 'array',
        'offers' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public $timestamps = false;

    protected $fillable = [
        'location',
        'title', 'salary', 'description',
        'requirements', 'responsibilities', 'offers',
    ];

    public function techSkill(): BelongsToMany
    {
        return $this->belongsToMany(TechSkill::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function scopeNotPublished(Builder $builder): Builder
    {
        return $builder->where('is_published', false);
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('is_published', true);
    }

    public function techSkillAsBaseArray(): array
    {
        return $this->techSkill->map(function ($skill) {
            return (object) [
                'id' => $skill->id,
                'skillName' => $skill->skill_name
            ];
        })->toArray();
    }

    public function isPublished(): bool
    {
        return $this->is_published;
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Vacancy $vacancy) {
            if (! $vacancy->created_at) {
                $vacancy->created_at = now();
            }
        });

        static::saved(function (Vacancy $vacancy) {
            Cache::forgetKey('vacancy', $vacancy->id);
        });
    }

}
