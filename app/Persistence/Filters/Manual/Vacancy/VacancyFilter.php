<?php

declare(strict_types=1);

namespace App\Persistence\Filters\Manual\Vacancy;

use App\Persistence\Filters\Manual\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class VacancyFilter extends BaseFilter
{

    protected const EMPLOYMENT = 'employment';

    protected const EXPERIENCE = 'experience';

    protected const SKILLS = 'skills';

    protected const SALARY = 'salary';

    protected const LOCATION = 'location';

    protected const CONSIDER = 'consider';

    public function getCallbacks(): array
    {
        return [
            self::SALARY => [$this, 'filterBySalary'],
            self::EMPLOYMENT => [$this, 'filterByEmployment'],
            self::EXPERIENCE => [$this, 'filterByExperience'],
            self::LOCATION => [$this, 'filterByLocation'],
            self::SKILLS => [$this, 'filterBySkills'],
            self::CONSIDER => [$this, 'filterByConsider'],
        ];
    }

    protected function filterBySalary(Builder $builder, int $value): void
    {
        $builder->where('salary', '<=', $value);
    }

    protected function filterByConsider(Builder $builder, bool $consider): void
    {
        $builder->when($consider, function (Builder $builder) {
            $builder->where('consider_without_experience', true);
        });
    }

    protected function filterByExperience(Builder $builder, int $years, bool $consider = false): void
    {
        $condition = (($years === 1 || $years === 0) && $consider);

        $builder->when($condition, function (Builder $builder) use ($years) {
            $builder->where(function (Builder $builder) use ($years) {
                $builder->where('experience_time', $years)->where('consider_without_experience', true);
            });
        }, function (Builder $builder) use ($years) {
            $builder->where('experience_time', $years);
        });
    }

    protected function filterByLocation(Builder $builder, string $location): void
    {
        $builder->where('location', 'like', $location.'%');
    }

    protected function filterByEmployment(Builder $builder, string $employment): void
    {
        $builder->where('employment_type', '=', $employment);
    }

    protected function filterBySkills(Builder $builder, int ...$skills): void
    {
        $builder->whereHas('techSkills', function (Builder $builder) use ($skills) {
            $builder->whereIn('tech_skill_id', $skills);
        });
    }
}