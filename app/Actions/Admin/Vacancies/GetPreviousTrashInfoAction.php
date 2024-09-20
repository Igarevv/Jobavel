<?php

declare(strict_types=1);

namespace App\Actions\Admin\Vacancies;

use App\Enums\Actions\AdminActionEnum;
use App\Persistence\Models\AdminAction;
use App\Persistence\Models\Vacancy;

class GetPreviousTrashInfoAction
{
    public function handle(Vacancy $vacancy): ?object
    {
        $trashInfo = $vacancy->actionsMadeByAdmin()
            ->where('action_name', AdminActionEnum::DELETE_VACANCY_TEMP_ACTION)
            ->latest('action_performed_at')
            ->first();

        if (! $trashInfo) {
            return null;
        }

        return  $this->prepareData($trashInfo);
    }

    private function prepareData(AdminAction $action): object
    {
        return (object) [
            'reason' => $action->reason->type,
            'description' => $action->reason->description,
            'comment' => $action->reason->comment,
            'performedAt' => $action->action_performed_at->format('Y-m-d H:i').' '.
                $action->action_performed_at->getTimezone()
        ];
    }
}
