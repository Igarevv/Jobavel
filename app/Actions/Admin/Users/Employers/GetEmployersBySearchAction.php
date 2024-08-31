<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Employers;

use App\DTO\Admin\AdminSearchDto;
use App\Persistence\Models\Employer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetEmployersBySearchAction
{
    public function __construct(
        private GetEmployersPaginatedAction $employersPaginatedAction
    ) {
    }

    public function handle(AdminSearchDto $searchDto): LengthAwarePaginator
    {
        if (Str::of($searchDto->getSearchable())->trim()->value() === '') {
            return $this->employersPaginatedAction->handle();
        }

        return $this->prepareData($this->fetchEmployers($searchDto));
    }

    private function fetchEmployers(AdminSearchDto $searchDto): LengthAwarePaginator
    {
        return Employer::query()
            ->with('user:id,email')
            ->search($searchDto)
            ->paginate(10, [
                'user_id',
                'employer_id',
                'company_name',
                'contact_email',
                'company_type',
                'created_at'
            ]);
    }

    private function prepareData(LengthAwarePaginator $employers): LengthAwarePaginator
    {
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
