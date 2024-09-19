<?php

declare(strict_types=1);

namespace App\Service\Admin\AdminActions;

use App\Contracts\Admin\AdminLogActionDtoInterface;
use App\Enums\Actions\AdminActionEnum;
use App\Persistence\Models\AdminAction;

class AdminLogActionService
{
    public function log(AdminLogActionDtoInterface $dto, AdminActionEnum $actionName): void
    {
        $action = new AdminAction();
        $action->admin_id = $dto->getAdmin()->id;
        $action->action_name = $actionName->value;
        $action->reason = [
            'type' => $dto->getReasonForAction()->toString(),
            'description' => $dto->getReasonForAction()->description(),
            'comment' => $dto->getComment(),
        ];

        $dto->getActionableModel()->actionsMadeByAdmin()->save($action);
    }
}
