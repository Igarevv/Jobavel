<?php

namespace App\Persistence\Models;

use App\Enums\Vacancy\ExperienceEnum;
use App\Observers\VacancyObserver;
use App\Persistence\Filters\Manual\FilterInterface;
use App\Persistence\Filters\Pipeline\PipelineFilterInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @mixin Builder
 * @method static static with($relations)
 * @method static Builder|static query()
 * @property-read  int employer_id
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
 * @property bool $consider_without_experience,
 * @property string $employment_type,
 * @property string $experience_time
 * @property Carbon $published_at
 * @method Builder|static notPublished()
 * @method Builder|static published()
 * @method Builder|static filter(FilterInterface $filter)
 */
#[ObservedBy(VacancyObserver::class)]
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
        'published_at' => 'datetime',
    ];

    protected $fillable = [
        'location', 'employment_type', 'experience_time',
        'title', 'salary', 'description',
        'requirements', 'responsibilities', 'offers',
        'consider_without_experience'
    ];

    protected $hidden = [
        'employer_id'
    ];

    public function techSkills(): BelongsToMany
    {
        return $this->belongsToMany(TechSkill::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function scopeNotPublished(Builder $builder): Builder
    {
        return $builder->where('is_published', false);
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('is_published', true);
    }

    public function scopeFilter(Builder $builder, FilterInterface $filter): Builder
    {
        $filter->apply($builder);

        return $builder;
    }

    public function scopePipelineFilter(Builder $builder, PipelineFilterInterface $filter): Builder
    {
        return $filter->process($builder);
    }

    public function techSkillsAsArrayOfBase(): Collection
    {
        return $this->techSkills->map(function ($skill) {
            return (object) [
                'id' => $skill->id,
                'skillName' => $skill->skill_name
            ];
        });
    }

    public function isPublished(): bool
    {
        return $this->is_published;
    }

    public function publish(): void
    {
        $this->is_published = true;

        $this->published_at = now();

        $this->save();
    }

    public function unpublish(): void
    {
        $this->is_published = false;

        $this->published_at = null;

        $this->save();
    }

    public function experienceFromString(): ?int
    {
        return ExperienceEnum::tryFrom($this->experience_time)?->experienceFromString();
    }

    protected function offers(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true) ?: null,
            set: fn($value) => json_encode($value) ?? []
        );
    }

    protected function experienceTime(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ExperienceEnum::experienceToString((float) $value),
        );
    }

    protected function employmentType(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value)
        );
    }

}
