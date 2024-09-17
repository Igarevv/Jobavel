<?php

namespace App\Service\Admin;

use App\DTO\Admin\AdminDeleteVacancyDto;
use App\Enums\Admin\DeleteVacancyTypeEnum;
use App\Enums\Admin\DeleteVacancyTypeEnum as DeleteEnum;
use App\Persistence\Models\AdminAction;
use App\Persistence\Models\Vacancy;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AdminVacancyService
{
    public function delete(AdminDeleteVacancyDto $dto): void
    {
        $vacancy = $dto->getVacancy();

        if ($dto->deleteVacancyTypeEnum() === DeleteEnum::DELETE_TRASH && $vacancy->trashed()) {
            throw new InvalidArgumentException('Cannot move to trash already trashed vacancy');
        }

        DB::transaction(function () use($dto, $vacancy) {
            if ($dto->deleteVacancyTypeEnum() === DeleteEnum::DELETE_PERMANENTLY) {
                $result = $vacancy->forceDelete();
            } else {
                $result = $vacancy->delete();
            }

            if ($result) {
                $this->logAction($dto);
            }
        });
    }

    protected function logAction(AdminDeleteVacancyDto $dto): void
    {
        $action = new AdminAction();
        $action->admin_id = $dto->getAdmin()->id;
        $action->action_name = $dto->deleteVacancyTypeEnum()->toActionName();
        $action->reason = [
            'type' => $dto->reasonToDeleteVacancyEnum()->toString(),
            'description' => $dto->reasonToDeleteVacancyEnum()->toString(),
            'comment' => $dto->getComment(),
        ];

        $dto->getVacancy()->actionsMadeByAdmin()
            ->save($action);
    }
}
