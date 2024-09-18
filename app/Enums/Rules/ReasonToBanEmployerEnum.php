<?php

namespace App\Enums\Rules;

use App\Contracts\Admin\AdminReasonEnumInterface;

enum ReasonToBanEmployerEnum: int implements AdminReasonEnumInterface
{
    case SPAM = 0;

    case OFFENSIVE_INAPPROPRIATE_BEHAVIOR = 1;

    case PROFANE_AGGRESSIVE_LANGUAGE = 2;

    case FRAUD_OR_DECEPTION = 3;

    case COPYRIGHT_INFRINGEMENT = 4;

    case DUPLICATION = 5;

    public function toString(): string
    {
        return match ($this) {
            self::SPAM => 'Spam',
            self::OFFENSIVE_INAPPROPRIATE_BEHAVIOR => 'Offensive or inappropriate behaviour',
            self::PROFANE_AGGRESSIVE_LANGUAGE => 'Profanity or aggressive language',
            self::FRAUD_OR_DECEPTION => 'Fraud or deception',
            self::COPYRIGHT_INFRINGEMENT => 'Copyright infringement.',
            self::DUPLICATION => 'Duplication'
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::SPAM => 'Sending promotional messages or fake job postings.',
            self::OFFENSIVE_INAPPROPRIATE_BEHAVIOR => 'Engaging in behavior that is considered offensive or inappropriate.',
            self::PROFANE_AGGRESSIVE_LANGUAGE => 'Using profanity or aggressive language.',
            self::FRAUD_OR_DECEPTION => 'Engaging in fraudulent activities or deception (e.g., providing false information about job postings).',
            self::COPYRIGHT_INFRINGEMENT => 'Posting content that violates copyright laws.',
            self::DUPLICATION => 'Job postings that are already published on the platform.'
        };
    }
}
