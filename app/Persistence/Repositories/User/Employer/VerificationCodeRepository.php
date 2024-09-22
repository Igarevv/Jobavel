<?php

declare(strict_types=1);

namespace App\Persistence\Repositories\User\Employer;

use App\Persistence\Contracts\VerificationCodeRepositoryInterface;
use App\Persistence\Models\Employer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

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
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => Carbon::now(),
            ]);
        });

        return $code;
    }

    public function setNewEmployerContactEmail(string $userId, string $email): void
    {
        DB::transaction(function () use ($userId, $email) {
            $this->deleteCode($userId);

            $employer = Employer::findByUuid($userId);

            $employer->contact_email = $email;

            $employer->save();
        });
    }

    public function getCodeByUserId(string $userId): ?stdClass
    {
        return DB::table('verification_codes')->where('user_id', $userId)->first();
    }

    public function deleteCode(string $userId): void
    {
        DB::table('verification_codes')->where('user_id', $userId)->delete();
    }

    public function updateCodeForResendingAction(int $code, string $userId): void
    {
        DB::table('verification_codes')->where('user_id', $userId)
            ->update([
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(30),
            ]);
    }
}
