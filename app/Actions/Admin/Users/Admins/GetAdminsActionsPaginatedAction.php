<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Admins;

use App\Persistence\Models\Admin;
use App\Persistence\Models\AdminAction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GetAdminsActionsPaginatedAction
{

    public function handle(Admin $admin): LengthAwarePaginator
    {
        $actions = AdminAction::query()
            ->with('actionable')
            ->where('admin_id', $admin->id)
            ->paginate(5);

        return $this->prepareData($actions);
    }

    private function prepareData(LengthAwarePaginator $actions): LengthAwarePaginator
    {
        return $actions->through(function (AdminAction $action) {
            return (object) [
                'name' => Str::ucfirst($action->action_name->toString()),
                'reasonType' => $action->reason->type,
                'entityName' => class_basename($action->actionable_type),
                'entityId' => $action->actionable?->getIdentifier() ?? 'Deleted: last id -'. $action->actionable_id,
                'performedAt' => $action->action_performed_at->format('Y-m-d H:i').' '.
                    $action->action_performed_at->getTimezone(),
            ];
        });
    }
}
