<?php

namespace App\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

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
    ];

    protected $hidden = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Employee $employee) {
            if ( ! $employee->employee_id) {
                $employee->employee_id = Uuid::uuid7()->toString();
            }
        });
    }

}
