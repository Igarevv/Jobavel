<?php

namespace App\Persistence\Models;

use App\Enums\Actions\AdminActionEnum;
use App\Enums\Vacancy\ExperienceEnum;
use App\Enums\Vacancy\VacancyStatusEnum;
use App\Observers\VacancyObserver;
use App\Persistence\Filters\Manual\FilterInterface;
use App\Persistence\Filters\Pipeline\PipelineFilterInterface;
use App\Persistence\Searcher\Searchers\VacancySearcher;
use App\Traits\Searchable\Searchable;
use App\Traits\Sortable\Sortable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @mixin Builder
 * @method static static with($relations)
 * @method static Builder|static query()
 * @property-read  int $employer_id
 * @property-read int $id
 * @property string $title
 * @property int $salary
 * @property string $slug
 * @property string $description
 * @property string $location
 * @property array $requirements,
 * @property array $responsibilities
 * @property array|null $offers
 * @property VacancyStatusEnum $status
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
    use Sortable;
    use Searchable;

    protected $casts = [
        'requirements' => 'array',
        'responsibilities' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'published_at' => 'datetime',
        'status' => VacancyStatusEnum::class,
    ];

    protected $fillable = [
        'location',
        'slug',
        'employment_type',
        'experience_time',
        'title',
        'salary',
        'description',
        'requirements',
        'responsibilities',
        'offers',
        'consider_without_experience',
        'response_number',
        'status',
    ];

    protected $hidden = [
        'employer_id',
    ];

    public function techSkills(): BelongsToMany
    {
        return $this->belongsToMany(TechSkill::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class)->withPivot('applied_at', 'has_cv');
    }

    public function actionsMadeByAdmin(): MorphMany
    {
        return $this->morphMany(AdminAction::class, 'actionable');
    }

    public function wasTrashedByAdmin(): bool
    {
        return $this->actionsMadeByAdmin()
            ->where('action_name', AdminActionEnum::DELETE_VACANCY_TEMP_ACTION)
            ->latest('action_performed_at')
            ->exists();
    }

    public function scopeNotPublished(Builder $builder): Builder
    {
        return $builder->where('status', VacancyStatusEnum::NOT_PUBLISHED->value);
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('status', VacancyStatusEnum::PUBLISHED->value);
    }

    public function scopeAllExceptPublishedAndTrashed(Builder $builder, Employer $employer): Builder
    {
        return $builder->where('employer_id', $employer->id)
            ->whereNotIn('status', [VacancyStatusEnum::PUBLISHED, VacancyStatusEnum::TRASHED]);
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
            return (object)[
                'id' => $skill->id,
                'skillName' => $skill->skill_name,
            ];
        });
    }

    public function isPublished(): bool
    {
        return $this->status === VacancyStatusEnum::PUBLISHED;
    }

    public function isNotPublished(): bool
    {
        return $this->status === VacancyStatusEnum::NOT_PUBLISHED;
    }

    public function isTrashed(): bool
    {
        return $this->status === VacancyStatusEnum::TRASHED;
    }

    public function isInModeration(): bool
    {
        return $this->status === VacancyStatusEnum::IN_MODERATION;
    }

    public function isApproved(): bool
    {
        return $this->status === VacancyStatusEnum::APPROVED;
    }

    public function isNotApproved(): bool
    {
        return $this->status === VacancyStatusEnum::NOT_APPROVED;
    }

    public function sendToModeration(): void
    {
        $this->status = VacancyStatusEnum::IN_MODERATION;

        $this->save();
    }

    public function publish(): void
    {
        $this->status = VacancyStatusEnum::PUBLISHED->value;

        $this->published_at = now();

        $this->save();
    }

    public function unpublish(): void
    {
        $this->status = VacancyStatusEnum::NOT_PUBLISHED->value;

        $this->published_at = null;

        $this->save();
    }

    public function approve(): void
    {
        $this->status = VacancyStatusEnum::APPROVED->value;

        $this->save();
    }

    public function reject(): void
    {
        $this->status = VacancyStatusEnum::NOT_APPROVED->value;

        $this->save();
    }

    public function publishedAtToString(): string
    {
        return $this->published_at
            ? $this->published_at?->format('Y-m-d H:i').' '.$this->published_at?->getTimezone()
            : 'Not published';
    }

    public function createdAtString(): string
    {
        return $this->created_at->format('Y-m-d H:i').' '.$this->created_at->getTimezone();
    }

    public function experienceFromString(): ?int
    {
        return ExperienceEnum::tryFrom($this->experience_time)?->experienceFromString();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
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
            get: fn($value) => ExperienceEnum::experienceToString((float)$value),
        );
    }

    protected function employmentType(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value)
        );
    }

    protected function searcher(): string
    {
        return VacancySearcher::class;
    }

    protected function sortableFields(): array
    {
        return [
            'creation-time' => 'created_at',
            'published-time' => 'published_at',
            'responses' => 'response_number',
        ];
    }

}
