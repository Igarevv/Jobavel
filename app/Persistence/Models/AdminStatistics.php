<?php

namespace App\Persistence\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminStatistics extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'vacancies_count',
        'employers_count',
        'employees_count',
        'record_at',
    ];

    protected $casts = [
        'record_at' => 'datetime',
    ];

    public function scopeSummarizeMonthlyStatistics(Builder $builder, array $range): Builder
    {
        return $builder->whereBetween('record_at', $range)
            ->selectRaw('SUM(vacancies_count) as vacancies_count')
            ->selectRaw('SUM(employers_count) as employers_count')
            ->selectRaw('SUM(employees_count) as employees_count');
    }
}
