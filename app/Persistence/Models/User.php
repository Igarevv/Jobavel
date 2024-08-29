<?php

namespace App\Persistence\Models;

use App\Enums\Role;
use App\Exceptions\InvalidRoleException;
use App\Persistence\Searcher\Searchers\UserSearcher;
use App\Traits\Searchable\Searchable;
use App\Traits\Searchable\SearchDtoInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail as Mailer;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static Builder|static unverified()
 * @method User|null first(array $columns = ['*'])
 * @method Builder search(SearchDtoInterface $searchDto)
 */
class User extends Model implements AuthContract, MustVerifyEmail, AuthorizableContract
{

    use Mailer;
    use HasFactory;
    use Authenticatable;
    use HasRoles;
    use Authorizable;
    use SoftDeletes;
    use Searchable;

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

    protected $casts = [
        'created_at' => 'datetime'
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

    public function admins(): HasOne
    {
        return $this->hasOne(Admin::class);
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

    public function scopeUnverified(Builder $builder): Builder
    {
        return $builder->where('is_confirmed', false);
    }

    public function markEmailAsVerified(): void
    {
        $this->is_confirmed = true;
        $this->email_verified_at = now();
        $this->save();
    }

    public function getEmailForVerification(): string
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

    protected function searcher(): string
    {
        return UserSearcher::class;
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
