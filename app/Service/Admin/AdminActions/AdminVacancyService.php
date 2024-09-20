<?php

namespace App\Service\Admin\AdminActions;

use App\DTO\Admin\AdminDeleteVacancyDto;
use App\DTO\Admin\AdminRejectVacancyDto;
use App\Enums\Actions\AdminActionEnum;
use App\Enums\Admin\DeleteVacancyTypeEnum as DeleteEnum;
use App\Persistence\Models\AdminAction;
use App\Persistence\Models\Vacancy;
use Illuminate\Database\Eloquent\Builder;
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
                $vacancy->reject();
            }

            if ($result) {
                $this->logActionService->log($dto, $dto->deleteVacancyTypeEnum()->toActionName());
            }
        });
    }

    public function approve(Vacancy $vacancy): void
    {
        $this->ensureStatusIsCorrect($vacancy);

        if ($vacancy->isApproved()) {
            throw new InvalidArgumentException('Cannot approve already approved vacancy');
        }

        if ($vacancy->isNotApproved() || $vacancy->isInModeration()) {
            DB::transaction(function () use ($vacancy) {
                AdminAction::query()->where('actionable_id', $vacancy->id)
                    ->where(function (Builder $builder) {
                        $builder->where('action_name', AdminActionEnum::REJECT_VACANCY_ACTION)
                            ->orWhere('action_name', AdminActionEnum::DELETE_VACANCY_TEMP_ACTION);
                    })
                    ->delete();

                $vacancy->approve();
            });
        }
    }

    public function reject(AdminRejectVacancyDto $dto): void
    {
        $vacancy = $dto->getActionableModel();

        $this->ensureStatusIsCorrect($vacancy);

        if ($vacancy->isNotApproved()) {
            throw new InvalidArgumentException('Cannot reject already rejected vacancy');
        }

        if ($vacancy->isApproved() || $vacancy->isInModeration()) {
            DB::transaction(function () use ($dto) {
                $dto->getActionableModel()->reject();

                $this->logActionService->log($dto, AdminActionEnum::REJECT_VACANCY_ACTION);
            });
        }
    }

    protected function ensureStatusIsCorrect(Vacancy $vacancy): void
    {
        if ($vacancy->isPublished() || $vacancy->isNotPublished() || $vacancy->isTrashed()) {
            throw new InvalidArgumentException('Cannot reject vacancy with this incorrect status');
        }
    }
}
