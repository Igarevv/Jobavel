<?php

namespace App\Events;

use App\DTO\Admin\AdminBannedUserDto;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserBanned implements ShouldDispatchAfterCommit
{

    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public AdminBannedUserDto $actionDto,
        public ?string $bannedUntil
    ) {
    }
}
