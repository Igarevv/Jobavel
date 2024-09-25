<?php

namespace App\Actions\Admin\Vacancies;

use App\DTO\Admin\AdminSearchDto;
use App\Enums\Vacancy\VacancyStatusEnum;
use App\Persistence\Models\Vacancy;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetVacanciesPaginatedAction
{
    public function handle(AdminSearchDto $searchDto, SortedValues $sortedValues): LengthAwarePaginator
    {
        if (Str::of($searchDto->getSearchable())->trim()->value() === '') {
            return $this->prepareData($this->getSortedOnly($sortedValues));
        }

        return $this->prepareData($this->getSearchedSorted($searchDto, $sortedValues));
    }

    private function getSortedOnly(SortedValues $sortedValues): LengthAwarePaginator
    {
        return Vacancy::withTrashed()
            ->whereNotIn('status', [VacancyStatusEnum::NOT_APPROVED, VacancyStatusEnum::IN_MODERATION])
            ->sortBy($sortedValues)
            ->paginate(20, [
                'slug',
                'title',
                'status',
                'employment_type',
                'response_number',
                'created_at',
                'published_at',
                'deleted_at'
            ]);
    }

    private function getSearchedSorted(AdminSearchDto $searchDto, SortedValues $sortedValues): LengthAwarePaginator
    {
        return Vacancy::withTrashed()
            ->whereNotIn('status', [VacancyStatusEnum::NOT_APPROVED, VacancyStatusEnum::IN_MODERATION])
            ->search($searchDto)
            ->sortBy($sortedValues)
            ->paginate(20, [
                'slug',
                'title',
                'employment_type',
                'response_number',
                'vacancies.created_at',
                'published_at',
                'status',
                'deleted_at'
            ]);
    }

    private function prepareData(LengthAwarePaginator $vacancies): LengthAwarePaginator
    {
        return $vacancies->through(function (Vacancy $vacancy) {
            return (object) [
                'slug' => $vacancy->slug,
                'title' => $vacancy->title,
                'status' => (object) [
                    'name' => $vacancy->status->toString(),
                    'color' => $vacancy->status->colorTailwind()
                ],
                'employment' => $vacancy->employment_type,
                'responses' => $vacancy->response_number,
                'createdAt' => $vacancy->createdAtString(),
                'publishedAt' => $vacancy->publishedAtToString(),
                'isTrashed' => $vacancy->trashed()
            ];
        });
    }
}
