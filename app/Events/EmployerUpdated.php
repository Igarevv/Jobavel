<?php

namespace App\Events;

use App\Persistence\Models\Employer;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmployerUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Employer $employer,
        public readonly string $newEmail
    ) {
    }

}
