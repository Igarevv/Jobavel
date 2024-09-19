<?php

namespace App\Enums\Actions;

use App\Contracts\Admin\AdminReasonEnumInterface;

enum ReasonToRejectVacancyEnum: int implements AdminReasonEnumInterface
{

    case CONTENT_MISMATCH = 0;

    case PUBLICATION_POLICY_VIOLATION = 1;

    case INCOMPLETE_INFORMATION = 2;

    case DUPLICATE = 3;

    case PRIVACY_VIOLATION = 4;

    public function toString(): string
    {
        return match ($this) {
            self::CONTENT_MISMATCH => 'Content Mismatch',
            self::PUBLICATION_POLICY_VIOLATION => 'Publication Policy Violation',
            self::INCOMPLETE_INFORMATION => 'Incomplete Information',
            self::DUPLICATE => 'Duplicate Job Listing',
            self::PRIVACY_VIOLATION => 'Privacy Violation'
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::CONTENT_MISMATCH => 'This occurs when the content of the job listing does not match the platform\'s guidelines or includes misleading information about the position or company.',
            self::PUBLICATION_POLICY_VIOLATION => 'This occurs when the job post violates specific rules or regulations, such as including inappropriate language, discriminatory terms, or offensive content.',
            self::INCOMPLETE_INFORMATION => 'This occurs the job post violates specific rules or regulations, such as including inappropriate language, discriminatory terms, or offensive content.',
            self::DUPLICATE => 'This occurs when job post identified as a duplicate of an already existing job listing from the same company.',
            self::PRIVACY_VIOLATION => 'This occurs when job listing includes personal information, sensitive data, or violates the privacy of individuals, it may be rejected.'
        };
    }

}
