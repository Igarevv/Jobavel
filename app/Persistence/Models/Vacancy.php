<?php

namespace App\Persistence\Models;

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
    ];

    public $timestamps = false;

    protected $fillable = [
        'employer_id',
        'title', 'salary', 'description',
        'requirements', 'responsibilities', 'offers',
    ];

    public function techSkills(): BelongsToMany
    {
        return $this->belongsToMany(TechSkill::class);
    }

    public function employers(): BelongsTo
    {
        return $this->belongsTo(Employer::class, ownerKey: 'id');
    }

}
