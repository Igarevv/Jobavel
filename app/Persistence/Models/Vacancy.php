<?php

namespace App\Persistence\Models;

use App\Service\Cache\Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int employer_id
 * @property string title
 * @property int $salary
 * @property string $description
 * @property string $location
 * @property array $requirements,
 * @property array $responsibilities
 * @property array|null $offers
 * @property bool $is_published
 * @property int $response_number
 * @property Carbon $created_at
 */
class Vacancy extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'requirements' => 'array',
        'responsibilities' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

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

    public function publish(): void
    {
        $this->is_published = true;

        $this->save();
    }

    public function unpublish(): void
    {
        $this->is_published = false;

        $this->save();
    }

    protected function offers(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true) ?: null,
            set: fn($value) => json_encode($value) ?? []
        );
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

        static::deleted(function (Vacancy $vacancy) {
            Cache::forgetKey('vacancy', $vacancy->id);
        });
    }

}
