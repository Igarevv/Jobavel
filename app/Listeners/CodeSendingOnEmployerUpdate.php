<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\EmployerUpdated;
use App\Service\Account\Employer\CodeVerificationService;

class CodeSendingOnEmployerUpdate
{
    public function __construct(
        private CodeVerificationService $codeVerificationService
    ) {
    }

    public function handle(EmployerUpdated $event): void
    {
        $employerId = $event->employer->employer_id ?: $event->employer->id;
        if (! $event->employer->compareEmails($event->newEmail)) {
            $this->codeVerificationService->sendEmail($employerId, $event->newEmail);
        }
    }

}