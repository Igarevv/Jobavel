<?php

namespace App\Http\Requests\Admin\Vacancy;

use App\DTO\Admin\AdminBannedUserDto;
use App\Enums\Actions\BanDurationEnum;
use App\Enums\Actions\ReasonToBanEmployerEnum;
use App\Persistence\Models\Employee;
use App\Persistence\Models\Employer;
use App\Traits\AfterValidation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminBanUserRequest extends FormRequest
{
    use AfterValidation;

    public function rules(): array
    {
        return [
            'reason_type' => ['required', Rule::enum(ReasonToBanEmployerEnum::class)],
            'duration' => ['required', Rule::enum(BanDurationEnum::class)],
            'comment' => ['nullable', 'string', 'max:512'],
        ];
    }

    public function makeCastAndMutatorsAfterValidation(array &$data): void
    {
        if ($this->has('reason_type')) {
            $data['reason_type'] = ReasonToBanEmployerEnum::tryFrom((int)$this->reason_type);
        }

        if ($this->has('duration')) {
            $data['duration'] = BanDurationEnum::tryFrom((int)$this->duration);
        }

        if ($this->has('comment')) {
            $data['comment'] = Str::of($this->comment ?? '')->trim()->value() ?: null;
        }
    }

    public function getDto(): AdminBannedUserDto
    {
        $data = $this->validated();

        return new AdminBannedUserDto(
            admin: $this->user('admin'),
            actionableUser: $this->guessUser(),
            reasonToBanEnum: $data['reason_type'],
            banDurationEnum: $data['duration'],
            comment: $data['comment']
        );
    }

    protected function guessUser(): ?Model
    {
        if ($this->route('employer')) {
            return Employer::findByUuid($this->route('employer'), ['id', 'user_id', 'employer_id', 'company_name']);
        }

        if ($this->route('employee')) {
            return Employee::findByUuid($this->route('employee'), ['id', 'user_id', 'employee_id', 'last_name', 'first_name']);
        }

        abort(404);
    }
}
