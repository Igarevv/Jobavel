<?php

namespace App\Persistence\Models;

use App\Enums\Admin\AdminAccountStatusEnum;
use App\Enums\Role;
use App\Traits\Sortable\Sortable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable as AuthorizableTrait;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model implements Authenticatable, \Illuminate\Contracts\Auth\Access\Authorizable
{
    use HasFactory;
    use HasRoles;
    use AuthorizableTrait;
    use AuthenticatableTrait;
    use Sortable;

    public const ADMIN = Role::ADMIN->value;

    public const SUPER_ADMIN = Role::SUPER_ADMIN->value;

    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'account_status',
    ];

    protected $hidden = [
        'id',
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
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

    public function scopeDeactivatedAdmins(Builder $builder): Builder
    {
        return $builder->where('account_status', AdminAccountStatusEnum::DEACTIVATED->value);
    }

    public function scopeActiveAdmins(Builder $builder): Builder
    {
        return $builder->where('account_status', AdminAccountStatusEnum::ACTIVE->value);
    }

    public function scopePendingAdmins(Builder $builder): Builder
    {
        return $builder->where('account_status', AdminAccountStatusEnum::PENDING_TO_AUTHORIZE->value);
    }

    public function scopeWithoutSuperAdmins(Builder $builder): Builder
    {
        return $builder->where('is_super_admin', false);
    }

    public function deactivate(): void
    {
        $this->account_status = AdminAccountStatusEnum::DEACTIVATED->value;
        $this->save();
    }

    public function createApiToken(): string
    {
        $this->api_token = Str::random(60);
        $this->save();
        return $this->api_token;
    }

    protected function sortableFields(): array
    {
        return [
            'status' => 'account_status',
            'creation-time' => 'created_at',
            'full-name' => 'last_name, first_name',
        ];
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
