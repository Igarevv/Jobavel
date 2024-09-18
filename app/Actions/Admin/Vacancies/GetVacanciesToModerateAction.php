<?php

declare(strict_types=1);

namespace App\Actions\Admin\Vacancies;

use App\Enums\Vacancy\VacancyStatusEnum;
use App\Persistence\Models\Vacancy;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator;

class GetVacanciesToModerateAction
{

    public function handle(SortedValues $sortedValues): LengthAwarePaginator
    {
        $vacancies = Vacancy::query()
            ->where('status', VacancyStatusEnum::IN_MODERATION)
            ->sortBy($sortedValues)
            ->paginate(10, ['title', 'slug', 'id', 'created_at']);

        return $this->prepareData($vacancies);
    }

    private function prepareData(LengthAwarePaginator $vacancies)
    {
        return $vacancies->through(function (Vacancy $vacancy) {
            return (object)[
                'title' => $vacancy->title,
                'slug' => $vacancy->slug,
                'createdAt' => $vacancy->createdAtString(),
            ];
        });
    }

}
