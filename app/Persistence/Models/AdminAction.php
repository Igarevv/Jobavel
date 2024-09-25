<?php

namespace App\Persistence\Models;

use App\Enums\Actions\AdminActionEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AdminAction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'actionable_type',
        'actionable_id',
        'reason',
        'action_name',
    ];

    protected $casts = [
        'action_performed_at' => 'datetime',
        'action_name' => AdminActionEnum::class
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function actionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function reason(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value)
        );
    }
}
