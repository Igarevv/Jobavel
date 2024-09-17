<?php

namespace App\Enums\Reason;

enum ReasonToBanEmployerEnum: int
{
    case SPAM = 0;

    case OFFENSIVE_INAPPROPRIATE_BEHAVIOR = 1;

    case PROFANE_AGGRESSIVE_LANGUAGE = 2;

    case FRAUD_OR_DECEPTION = 3;

    case COPYRIGHT_INFRINGEMENT = 4;

    case DUPLICATION = 5;

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
