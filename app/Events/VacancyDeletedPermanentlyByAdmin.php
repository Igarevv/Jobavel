<?php

namespace App\Events;

use App\Contracts\Admin\AdminLogActionDtoInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VacancyDeletedPermanentlyByAdmin
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public AdminLogActionDtoInterface $actionDto
    ) {
    }
}
