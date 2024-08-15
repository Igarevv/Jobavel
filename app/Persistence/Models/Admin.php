<?php

namespace App\Persistence\Models;

use App\Enums\Role;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model implements Authenticatable, \Illuminate\Contracts\Auth\Access\Authorizable
{
    use HasFactory;
    use HasRoles;
    use \Illuminate\Auth\Authenticatable;
    use Authorizable;

    public const ADMIN = Role::ADMIN->value;

    public const SUPER_ADMIN = Role::SUPER_ADMIN->value;

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
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
