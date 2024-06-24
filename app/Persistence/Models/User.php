<?php

namespace App\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class User extends Model
{

    use HasFactory;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'id',
    ];

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
