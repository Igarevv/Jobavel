<?php

namespace App\Persistence\Models;

use App\Service\Cache\Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

/**
 * @property string $company_name,
 * @property string $employer_id,
 * @property string $company_description,
 * @property string $company_logo,
 * @property Carbon $created_at
 * @property string $contact_email
 */
class Employer extends Model
{

    use HasFactory;

    protected $table = 'employers';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_email',
        'company_description',
        'company_type'
    ];

    protected $hidden = [
        'id',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vacancy(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    public function scopeByUuid(Builder $builder, string $uuid): Builder
    {
        return $builder->where('employer_id', $uuid);
    }

    public function compareEmails(string $newEmail): bool
    {
        return $this->contact_email === $newEmail;
    }

    public function getEmpId(): string
    {
        return $this->employer_id;
    }

    public function getFullName(): string
    {
        return $this->company_name;
    }

    public function companyType(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value)
        );
    }

    public static function findByUuid(string $uuid, array $columns = ['*']): Employer
    {
        return static::where('employer_id', $uuid)->firstOrFail($columns);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Employer $employer) {
            if (! $employer->employer_id) {
                $employer->employer_id = Uuid::uuid7()->toString();
            }
        });

        static::saved(function (Employer $employer) {
            Cache::forgetKey('vacancy-employer', $employer->employer_id);
        });
    }

}
