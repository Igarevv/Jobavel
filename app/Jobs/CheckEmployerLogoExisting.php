<?php

namespace App\Jobs;

use App\Contracts\Storage\LogoStorageInterface;
use App\Persistence\Models\Employer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimitedWithRedis;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckEmployerLogoExisting implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private LogoStorageInterface $logoStorage,
        public Employer $employer
    ) {
    }

    public function handle(): void
    {
        if (! $this->logoStorage->isExists($this->employer->company_logo)) {
            $this->employer->update(['company_logo' => config('app.default_employer_logo')]);
            Log::info('image-updated');
        }
        Log::info('process job');
    }

    public function middleware(): array
    {
        return [(new RateLimitedWithRedis('redis-job-limiter'))];
    }
}
