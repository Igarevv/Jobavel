<?php

namespace App\Persistence\Models;

use App\Observers\TechSkillObserver;
use App\Persistence\Searcher\Searchers\TechSkillSearcher;
use App\Traits\Searchable\Searchable;
use App\Traits\Sortable\Sortable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy(TechSkillObserver::class)]
class TechSkill extends Model
{

    use HasFactory;
    use Sortable;
    use Searchable;
    protected $fillable = [
        'skill_name',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function vacancies(): BelongsToMany
    {
        return $this->belongsToMany(Vacancy::class);
    }

    public function createdAtToString(): string
    {
        return $this->created_at->format('Y-m-d H:i').' '.$this->created_at->getTimezone();
    }

    public function updatedAtToString(): string
    {
        return $this->updated_at
            ? $this->updated_at->format('Y-m-d H:i').' '.$this->created_at->getTimezone()
            : 'Not updated yet';
    }

    protected function sortableFields(): array
    {
        return [
            'creation_time' => 'created_at',
            'skill' => 'skill_name',
            'update-time' => 'updated_at'
        ];
    }

    protected function searcher(): string
    {
        return TechSkillSearcher::class;
    }

}
