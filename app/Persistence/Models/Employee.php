<?php

namespace App\Persistence\Models;

use App\Persistence\Searcher\Searchers\EmployeeSearcher;
use App\Traits\Searchable\Searchable;
use App\Traits\Sortable\Sortable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

/**
 * @property string $first_name,
 * @property string $last_name,
 * @property string $position,
 * @property string $email,
 * @property int $preferred_salary,
 * @property string $about_me,
 * @property array $experiences,
 * @property string $resume_file
 * @property Carbon|null $created_at
 */
class Employee extends Model
{
    use Searchable;
    use HasFactory;
    use Sortable;

    protected $table = 'employees';

    public const CV_TYPE_MANUAL = 0;

    public const CV_TYPE_FILE = 1;

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'email',
        'position',
        'preferred_salary',
        'about_me',
        'experiences',
        'skills',
        'resume_file',
        'created_at',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'skills' => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vacancies(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class)->withPivot('applied_at', 'has_cv');
    }

    public function actionsMadeByAdmin(): MorphMany
    {
        return $this->morphMany(AdminAction::class, 'actionable');
    }

    public function userId(): string
    {
        return $this->user->getUuidKey();
    }

    public function getAccountEmail(): string
    {
        return $this->user->getEmail();
    }

    public function experiences(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value, JSON_UNESCAPED_SLASHES)
        );
    }

    public function getUuid(): ?string
    {
        return $this->employee_id;
    }

    public function getFullName(): ?string
    {
        return $this->last_name.' '.$this->first_name;
    }

    public function hasMinimallyFilledPersonalInfo(): bool
    {
        return $this->position && $this->about_me;
    }

    public function cvFileName(): ?string
    {
        $employeeName = Str::lower(preg_replace('/\s+/', '-', $this->getFullName()));

        $extension = File::extension($this->resume_file);

        return $extension ? $employeeName.'.'.$extension : null;
    }

    public function clearCvPath(): void
    {
        $this->resume_file = null;

        $this->save();
    }

    public static function findByUuid(string $uuid, array $columns = ['*']): static
    {
        return static::where('employee_id', $uuid)->firstOrFail($columns);
    }

    protected function searcher(): string
    {
        return EmployeeSearcher::class;
    }

    protected function sortableFields(): array
    {
        return [
            'creation-time' => 'created_at',
            'full-name' => 'last_name, first_name',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Employee $employee) {
            if (! $employee->employee_id) {
                $employee->employee_id = Uuid::uuid7()->toString();
            }
        });
    }
}
