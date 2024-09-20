<?php

namespace App\Http\Requests\Admin\Vacancy;

use App\DTO\Admin\AdminRejectVacancyDto;
use App\Enums\Actions\ReasonToRejectVacancyEnum;
use App\Persistence\Models\Admin;
use App\Persistence\Models\Vacancy;
use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminRejectVacancyRequest extends FormRequest
{
    use AfterValidation;

    private Vacancy $vacancy;

    public function authorize(): bool
    {
        $this->vacancy = $this->route('vacancy')?->createFromSlug('id', 'status', 'deleted_at');

        return $this->user('admin')?->can('moderate', [Admin::class, $this->vacancy]) !== null;
    }

    public function rules(): array
    {
        return [
            'reason_type' => ['required', Rule::enum(ReasonToRejectVacancyEnum::class)],
            'comment' => ['nullable', 'string', 'max:512'],
        ];
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        if ($this->has('reason_type')) {
            $data['reason_type'] = ReasonToRejectVacancyEnum::tryFrom($this->reason_type);
        }

        if ($this->has('comment')) {
            $data['comment'] = Str::of($this->comment ?? '')->trim()->value() ?: null;
        }
    }

    public function getDto(): AdminRejectVacancyDto
    {
        $data = $this->validated();

        return new AdminRejectVacancyDto(
            admin: $this->user('admin'),
            vacancy: $this->vacancy,
            reasonEnum: $data['reason_type'],
            comment: $data['comment']
        );
    }
}
