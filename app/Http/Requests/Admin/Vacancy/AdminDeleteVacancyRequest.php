<?php

namespace App\Http\Requests\Admin\Vacancy;

use App\DTO\Admin\AdminDeleteVacancyDto;
use App\Enums\Admin\DeleteVacancyTypeEnum;
use App\Enums\Reason\ReasonToDeleteVacancyEnum;
use App\Persistence\Models\Vacancy;
use App\Traits\AfterValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminDeleteVacancyRequest extends FormRequest
{
    use AfterValidation;

    public function authorize(): bool
    {
        return $this->user('admin')?->can('delete', Vacancy::class) !== null;
    }

    public function rules(): array
    {
        return [
            'delete_type' => ['required', Rule::enum(DeleteVacancyTypeEnum::class)],
            'reason_type' => ['required', Rule::enum(ReasonToDeleteVacancyEnum::class)],
            'comment' => ['nullable', 'string', 'max:512']
        ];
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        if ($this->has('delete-type')) {
            $data['delete-type'] = DeleteVacancyTypeEnum::tryFrom($this->delete_type);
        }

        if ($this->has('reason-type')) {
            $data['reason-type'] = ReasonToDeleteVacancyEnum::tryFrom($this->reason_type);
        }

        if ($this->has('comment')) {
            $data['comment'] = Str::of($this->reason ?? '')->trim()->value() ?: null;
        }
    }

    public function getDto(): AdminDeleteVacancyDto
    {
        $data = $this->validated();

        return new AdminDeleteVacancyDto(
            admin: $this->user('admin'),
            vacancy: $this->route('vacancy')?->createFromSlug('id'),
            reasonEnum: $data['reason_type'],
            adminDeleteVacancyEnum: $data['delete_type'],
            comment: $data['comment']
        );
    }
}
