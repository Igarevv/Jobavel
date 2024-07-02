<?php

namespace App\Http\Requests;

use App\Persistence\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CustomEmailVerificationRequest extends FormRequest
{

    protected ?User $user;

    public function authorize(): bool
    {
        $this->user = $this->userByUuid();

        if ( ! hash_equals(
            $this->user->getUuidKey(),
            (string)$this->route('user_id')
        )) {
            return false;
        }

        if ( ! hash_equals(
            sha1($this->user->getEmailForVerification()),
            (string)$this->route('hash')
        )) {
            return false;
        }

        return true;
    }

    public function fulfill(): ?User
    {
        if ( ! $this->user->hasVerifiedEmail()) {
            $this->user->markEmailAsVerified();

            event(new Verified($this->user));
        }
        return $this->user;
    }

    public function withValidator(Validator $validator): Validator
    {
        return $validator;
    }

    protected function userByUuid(): User|Builder
    {
        return User::query()
            ->where('user_id', $this->route('user_id'))
            ->firstOrFail();
    }

}
