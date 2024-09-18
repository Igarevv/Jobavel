<?php

namespace App\Service\Admin\AdminActions;

use App\DTO\Admin\AdminDeleteVacancyDto;
use App\Enums\Admin\DeleteVacancyTypeEnum as DeleteEnum;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class AdminVacancyService
{
    public function __construct(
        protected AdminLogActionService $logActionService
    ) {}

    public function delete(AdminDeleteVacancyDto $dto): void
    {
        $vacancy = $dto->getActionableModel();

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
                $this->logActionService->log($dto, $dto->deleteVacancyTypeEnum()->toActionName());
            }
        });
    }
}
