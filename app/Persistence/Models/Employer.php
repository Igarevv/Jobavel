<?php

namespace App\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Employer extends Model
{

    use HasFactory;

    protected $table = 'employers';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_email',
    ];

    protected $hidden = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vacancy(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Employer $employer) {
            if ( ! $employer->employer_id) {
                $employer->employer_id = Uuid::uuid7()->toString();
            }
        });
    }

}
