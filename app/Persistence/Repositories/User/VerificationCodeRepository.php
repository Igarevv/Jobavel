<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\User;

use App\Persistence\Contracts\VerificationCodeRepositoryInterface;
use App\Persistence\Models\Employer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VerificationCodeRepository implements VerificationCodeRepositoryInterface
{
    public function saveVerificationCode(string|int $userId, string $newEmail, int $code): int
    {
        DB::transaction(function () use ($code, $userId, $newEmail) {
            $this->deleteCode($userId);

            DB::table('verification_codes')->insert([
                'user_id' => $userId,
                'code' => $code,
                'new_contact_email' => $newEmail,
                'expires_at' => Carbon::now()->addMinutes(30),
            ]);
        });

        return $code;
    }

    public function setNewEmployerContactEmail(string|int $userId, string $email): void
    {
        DB::transaction(function () use ($userId, $email) {
            $this->deleteCode($userId);

            $employer = Employer::findByUuid($userId);

            $employer->contact_email = $email;

            $employer->save();
        });
    }

    public function getCodeByUserId(string|int $userId): ?\stdClass
    {
        return DB::table('verification_codes')->where('user_id', $userId)->first();
    }

    protected function deleteCode(int|string $userId): void
    {
        DB::table('verification_codes')->where('user_id', $userId)->delete();
    }

    public function updateCodeForResendingAction(int $code, int|string $userId): void
    {
        DB::table('verification_codes')->where('user_id', $userId)
            ->update([
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(30),
            ]);
    }
}