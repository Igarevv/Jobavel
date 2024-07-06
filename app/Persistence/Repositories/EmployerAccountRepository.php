<?php

declare(strict_types=1);

namespace App\Persistence\Repositories;

use App\Persistence\Contracts\AccountRepositoryInterface;
use App\Persistence\Models\Employer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class EmployerAccountRepository implements AccountRepositoryInterface
{

    public function getById(int|string $userId): ?Employer
    {
        return Employer::query()->where('employer_id', $userId)->first([
            'employer_id', 'contact_email', 'created_at',
            'company_name', 'company_logo', 'company_description',
        ]);
    }

    public function update(string|int $userId, array $data): Employer
    {
        $employer = Employer::query()->where('employer_id', $userId)->first();

        if (! $employer) {
            throw new ModelNotFoundException('Tried to updated unknown user with id'.$userId);
        }

        $employer->contact_email = $data['email'];
        $employer->company_name = $data['name'];
        $employer->company_description = $data['description'];

        if ($employer->isDirty('contact_email')) {
            $employer->contact_email_verified = false;
        }

        $employer->save();

        return $employer;
    }

    public function generateAndSaveVerificationCode(string|int $userId): int
    {
        $code = random_int(100_000, 999_999);

        DB::transaction(function () use ($code, $userId) {
            $this->deleteCode($userId);

            DB::table('verification_codes')->insert([
                'user_id' => $userId,
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(1),
            ]);
        });

        return $code;
    }

    public function setEmployerContactEmailVerified(string|int $userId): void
    {
        DB::transaction(function () use ($userId) {
            $this->deleteCode($userId);

            Employer::query()->where('employer_id', $userId)->update([
                'contact_email_verified' => true
            ]);
        });
    }

    public function getCodeByUserId(string|int $userId): \stdClass
    {
        return DB::table('verification_codes')->where('user_id', $userId)->first();
    }

    protected function deleteCode(int|string $userId): void
    {
        DB::table('verification_codes')->where('user_id', $userId)->delete();
    }

}
