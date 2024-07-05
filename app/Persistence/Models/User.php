<?php

namespace App\Persistence\Models;

use App\Enums\Role;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail as Mailer;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Model implements AuthContract, MustVerifyEmail
{

    use Mailer;
    use HasFactory;
    use Authenticatable;
    use Notifiable;

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

    public function getUserIdByRole(): int
    {
        $user = $this->getRole()->getAssociatedDataByRole($this);
        $this->employer->id;
        return $user->id;
    }

    public function getRole(): Role
    {
        return Role::tryFrom($this->role);
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
