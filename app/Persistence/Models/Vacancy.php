<?php

namespace App\Persistence\Models;

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
 * @property array $requirements,
 * @property array $responsibilities
 * @property array $offers
 * @property bool $is_published
 * @property int $response_number
 */
class Vacancy extends Model
{

    use HasFactory;

    protected $casts = [
        'requirements' => 'array',
        'responsibilities' => 'array',
        'offers' => 'array',
        'created_at' => 'datetime',
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
        return $this->belongsTo(Employer::class, ownerKey: 'id');
    }

    public function isPublished(): bool
    {
        return $this->is_published;
    }

    public function scopeNotPublished(Builder $builder): Builder
    {
        return $builder->where('is_published', false);
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('is_published', true);
    }

}
