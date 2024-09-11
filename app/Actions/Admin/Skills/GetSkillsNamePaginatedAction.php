<?php

namespace App\Actions\Admin\Skills;

use App\DTO\Admin\AdminSearchDto;
use App\Persistence\Models\TechSkill;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetSkillsNamePaginatedAction
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
        return TechSkill::query()
            ->sortBy($sortedValues)
            ->paginate(10);
    }

    private function getSearchedSorted(AdminSearchDto $searchDto, SortedValues $sortedValues): LengthAwarePaginator
    {
        return TechSkill::query()
            ->search($searchDto)
            ->sortBy($sortedValues)
            ->paginate(10);
    }

    private function prepareData(LengthAwarePaginator $skills): LengthAwarePaginator
    {
        return $skills->through(function (TechSkill $skill) {
            return (object) [
                'id' => $skill->id,
                'name' => $skill->skill_name,
                'createdAt' => $skill->createdAtToString(),
                'updatedAt' => $skill->updatedAtToString(),
            ];
        });
    }
}
