<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Employers;

use App\DTO\Admin\AdminSearchDto;
use App\Persistence\Models\Employer;
use App\Traits\Sortable\VO\SortedValues;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetEmployersPaginatedAction
{

    public function handle(
        AdminSearchDto $searchDto,
        SortedValues $sortedValues
    ): LengthAwarePaginator {
        if (Str::of($searchDto->getSearchable())->trim()->value() === '') {
            return $this->prepareData($this->getSortedOnly($sortedValues));
        }

        return $this->prepareData(
            $this->getSearchedSorted($searchDto, $sortedValues)
        );
    }

    private function getSortedOnly(SortedValues $sortedValue
    ): LengthAwarePaginator {
        return Employer::with('user:id,email')
            ->sortBy($sortedValue)
            ->paginate(10, [
                'user_id',
                'employer_id',
                'company_name',
                'contact_email',
                'company_type',
                'created_at',
            ]);
    }

    private function getSearchedSorted(
        AdminSearchDto $searchDto,
        SortedValues $sortedValue
    ): LengthAwarePaginator {
        return Employer::query()
            ->with('user:id,email')
            ->search($searchDto)
            ->sortBy($sortedValue)
            ->paginate(10, [
                'user_id',
                'employer_id',
                'company_name',
                'contact_email',
                'company_type',
                'created_at',
            ]);
    }

    private function prepareData(LengthAwarePaginator $employers
    ): LengthAwarePaginator {
        return $employers->through(function (Employer $employer) {
            return (object)[
                'id' => $employer->employer_id,
                'idEncrypted' => Str::mask($employer->employer_id, '*', 5, -2),
                'company' => $employer->company_name,
                'companyType' => $employer->company_type,
                'contactEmail' => $employer->contact_email,
                'accountEmail' => $employer->user->email,
                'createdAt' => $employer->created_at->format('Y-m-d H:i').' '.
                    $employer->created_at->getTimezone(),
            ];
        });
    }

}
