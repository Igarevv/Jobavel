<?php

namespace App\Persistence\Models;

use App\Enums\Role;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable as AuthorizableTrait;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model implements Authenticatable, \Illuminate\Contracts\Auth\Access\Authorizable
{
    use HasFactory;
    use HasRoles;
    use AuthorizableTrait;
    use AuthenticatableTrait;

    public const ADMIN = Role::ADMIN->value;

    public const SUPER_ADMIN = Role::SUPER_ADMIN->value;

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_active'
    ];

    protected $hidden = [
        'id',
        'password'
    ];

    public function makeAdminAsSuperAdmin(): void
    {
        $this->is_super_admin = true;
        $this->save();
    }

    public function getFullName(): string
    {
        return "{$this->last_name} {$this->first_name}";
    }

    public function getDefaultGuardName(): string
    {
        return 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    public function deactivate(): void
    {
        $this->is_active = false;
        $this->save();
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Admin $admin) {
            if (! $admin->admin_id) {
                $admin->admin_id = Uuid::uuid7()->toString();
            }
        });
    }
}
