<?php

namespace App\Enums\Reason;

enum ReasonToDeleteVacancyEnum: int
{
    case INAPPROPRIATE_CONTENT = 0;

    case DUPLICATE = 1;

    case INACCURATE_INFORMATION = 2;

    case LEGAL_COMPLIANCE = 3;

    public function toString(): string
    {
        return match ($this) {
            self::INAPPROPRIATE_CONTENT => 'Inappropriate content',
            self::DUPLICATE => 'Duplicate',
            self::INACCURATE_INFORMATION => 'Inaccurate information',
            self::LEGAL_COMPLIANCE => 'Legal compliance'
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::INAPPROPRIATE_CONTENT => 'The job posting includes inappropriate or offensive content that does not meet the company\'s standards.',
            self::DUPLICATE => 'The job posting is a duplicate of another active job posting and needs to be removed to avoid redundancy.',
            self::INACCURATE_INFORMATION => 'The job posting contains incorrect or misleading information about the role, qualifications, or company.',
            self::LEGAL_COMPLIANCE => 'The job posting must be removed to comply with legal or regulatory requirements.'
        };
    }
}
