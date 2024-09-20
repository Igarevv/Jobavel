<?php

namespace App\Events;

use App\DTO\Admin\AdminBannedUserDto;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserBanned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public AdminBannedUserDto $actionDto,
        public ?string $bannedUntil
    ) {
    }
}
