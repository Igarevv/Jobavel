<?php

namespace App\Persistence\Models;

use App\Enums\Role;
use App\Exceptions\InvalidRoleException;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail as Mailer;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements AuthContract, MustVerifyEmail, AuthorizableContract
{

    use Mailer;
    use HasFactory;
    use Authenticatable;
    use HasRoles;
    use Authorizable;

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

    public function getAuthIdentifierName(): string
    {
        return 'user_id';
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function employer(): HasOne
    {
        return $this->hasOne(Employer::class);
    }

    public function getRole(): string
    {
        return $this->getRoleNames()->first();
    }

    public function isEmployee(): bool
    {
        return $this->role === self::EMPLOYEE;
    }

    public function isEmployer(): bool
    {
        return $this->role === self::EMPLOYER;
    }

    public function markEmailAsVerified(): void
    {
        $this->is_confirmed = true;
        $this->email_verified_at = now();
        $this->save();
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }

    public function getUuidKey(): string
    {
        return $this->user_id;
    }

    public function getRelationByUserRole(): HasOne
    {
        return match ($this->getRole()) {
            self::EMPLOYER => $this->employer(),
            self::EMPLOYEE => $this->employee(),
            default => throw new InvalidRoleException('Invalid role')
        };
    }

    public function getRelationDataByUserRole(): Model
    {
        return match ($this->getRole()) {
            self::EMPLOYER => $this->employer,
            self::EMPLOYEE => $this->employee,
            default => throw new InvalidRoleException('Invalid role')
        };
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (User $user) {
            if (! $user->user_id) {
                $user->user_id = Uuid::uuid7()->toString();
            }
        });
    }

}
