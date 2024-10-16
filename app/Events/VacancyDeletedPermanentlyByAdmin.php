<?php

namespace App\Events;

use App\Contracts\Admin\AdminLogActionDtoInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VacancyDeletedPermanentlyByAdmin implements ShouldDispatchAfterCommit
{

    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public AdminLogActionDtoInterface $actionDto
    ) {
    }
}
