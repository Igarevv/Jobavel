<?php

namespace App\Persistence\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

/**
 * @property string $first_name,
 * @property string $last_name,
 * @property string $position,
 * @property string $email,
 * @property int $preferred_salary,
 * @property string $about_me,
 * @property array $experiences
 */
class Employee extends Model
{

    use HasFactory;

    protected $table = 'employees';

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
        'skills'
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'skills' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function experiences(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value, JSON_UNESCAPED_SLASHES)
        );
    }

    public function getEmpId(): ?string
    {
        return $this->employee_id;
    }

    public function getFullName(): ?string
    {
        return $this->last_name.' '.$this->first_name;
    }

    public static function findByUuid(string $uuid, array $columns = ['*']): static
    {
        return static::where('employee_id', $uuid)->firstOrFail($columns);
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
