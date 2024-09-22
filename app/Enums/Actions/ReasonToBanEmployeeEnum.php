<?php

namespace App\Enums\Actions;

use App\Contracts\Admin\AdminReasonEnumInterface;

enum ReasonToBanEmployeeEnum: int implements AdminReasonEnumInterface
{

    case FRAUDULENT_ACTIVITY = 0;

    case ABUSE_OF_PLATFORM = 1;

    case INAPPROPRIATE_CONTENT = 2;

    case ILLEGAL_ACTIVITIES = 3;

    case VIOLATION_OF_TERMS_OF_SERVICE = 4;

    public function toString(): string
    {
        return match ($this) {
            self::FRAUDULENT_ACTIVITY => 'Fraudulent activity',
            self::ABUSE_OF_PLATFORM => 'Abuse of platform',
            self::INAPPROPRIATE_CONTENT => 'Inappropriate content',
            self::ILLEGAL_ACTIVITIES => 'Illegal activities',
            self::VIOLATION_OF_TERMS_OF_SERVICE => 'Violation of terms of service',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::FRAUDULENT_ACTIVITY => 'Engaging in activities like submitting fake credentials, falsifying experience or qualifications, or other dishonest behavior.',
            self::ABUSE_OF_PLATFORM => 'Repeated misuse of the app, such as spamming job applications, providing misleading information, or abusing platform features.',
            self::INAPPROPRIATE_CONTENT => 'Posting or sharing offensive, explicit, or unprofessional content in profiles, messages, or application materials.',
            self::ILLEGAL_ACTIVITIES => 'Involvement in illegal activities, either within or outside the platform, that jeopardize the integrity of the app.',
            self::VIOLATION_OF_TERMS_OF_SERVICE => 'Breaching the platform’s terms of service, including inappropriate behavior, harassment, or disrespectful interactions with employers.',
        };
    }

}
