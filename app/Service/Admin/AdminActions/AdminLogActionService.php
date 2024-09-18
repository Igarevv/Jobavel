<?php

declare(strict_types=1);

namespace App\Service\Admin\AdminActions;

use App\Contracts\Admin\AdminActionDtoInterface;
use App\Persistence\Models\AdminAction;

class AdminLogActionService
{
    public function log(AdminActionDtoInterface $dto, string $actionName): void
    {
        $action = new AdminAction();
        $action->admin_id = $dto->getAdmin()->id;
        $action->action_name = $actionName;
        $action->reason = [
            'type' => $dto->getReasonForAction()->toString(),
            'description' => $dto->getReasonForAction()->description(),
            'comment' => $dto->getComment(),
        ];

        $dto->getActionableModel()->actionsMadeByAdmin()->save($action);
    }
}
