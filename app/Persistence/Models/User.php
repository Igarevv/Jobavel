<?php

namespace App\Persistence\Models;

use App\Enums\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Uuid;

class User extends Model implements AuthContract
{

    use HasFactory;
    use Authenticatable;

    public const EMPLOYEE = Role::EMPLOYEE->value;

    public const EMPLOYER = Role::EMPLOYER->value;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'id',
        'remember_token',
    ];

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function employer(): HasOne
    {
        return $this->hasOne(Employer::class);
    }

    public function getRole(): Role
    {
        return Role::tryFrom($this->role);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            if ( ! $user->user_id) {
                $user->user_id = Uuid::uuid7()->toString();
            }
        });
    }

}
