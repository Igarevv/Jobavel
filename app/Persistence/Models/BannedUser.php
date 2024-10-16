<?php

namespace App\Persistence\Models;

use App\Enums\Actions\BanDurationEnum;
use App\Enums\Actions\ReasonToBanEmployerEnum;
use App\Persistence\Searcher\Searchers\BannedUserSearcher;
use App\Traits\Searchable\Searchable;
use App\Traits\Searchable\SearchDtoInterface;
use App\Traits\Sortable\Sortable;
use App\Traits\Sortable\VO\SortedValues;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $banned_until
 * @method static BannedUser create(array $attributes = [])
 * @method static Builder|static sortBy(SortedValues $sortedValues)
 * @method Builder|static search(Builder $builder, SearchDtoInterface $searchDto)
 */
class BannedUser extends Model
{
    use HasFactory;
    use Sortable;
    use Searchable;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'reason_type',
        'comment',
        'duration',
        'banned_until',
        'email',
    ];

    protected $casts = [
        'banned_until' => 'datetime',
        'banned_at' => 'datetime',
        'duration' => BanDurationEnum::class,
        'reason_type' => ReasonToBanEmployerEnum::class,
    ];

    public function scopeUser(Builder $builder, string $userId): Builder
    {
        return $builder->where('user_id', $userId);
    }

    public function bannedUntil(): string
    {
        return $this->banned_until
            ? $this->banned_until->format('Y-m-d H:i').' '.$this->banned_until->getTimezone()
            : '-';
    }

    public static function latestBanForUser(?User $user, array $columns = ['*']): ?BannedUser
    {
        if (! $user) {
            return null;
        }

        return static::where('user_id', $user->user_id)->latest('banned_at')->first($columns);
    }

    public function isBannedPermanently(): bool
    {
        return is_null($this->banned_until);
    }

    public function isBannedTemporarily(): bool
    {
        return ! is_null($this->banned_until);
    }

    protected function searcher(): string
    {
        return BannedUserSearcher::class;
    }

    protected function sortableFields(): array
    {
        return [
            'banned-time' => 'banned_at',
        ];
    }

}
