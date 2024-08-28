<?php

declare(strict_types=1);

namespace App\Actions\Admin\Users\Unverified;

use App\Exceptions\TooManyEmailsForUnverifiedUsersPerDay;
use App\Jobs\SendEmailToAllUnverifiedUsers;
use App\Persistence\Models\User;
use App\Service\Cache\Cache;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SendEmailToAllUnverifiedUsersAction
{
    public function __construct(
        private Dispatcher $dispatcher,
        private Cache $cache
    ) {
    }

    public function handle(): void
    {
        if ($this->cache->repository()->get($this->cache->getCacheKey('admin-send-emails-once-per-day'))) {
            throw new TooManyEmailsForUnverifiedUsersPerDay(
                'Sending emails to unverified users allowed only once per day for all admins'
            );
        }

        $unverifiedUserWithinMonth = User::unverified()
            ->where('created_at', now()->subMonth()->startOfDay())
            ->get(['email', 'user_id']);

        if (! $unverifiedUserWithinMonth) {
            throw new ModelNotFoundException('Unverified users not found');
        }

        $this->dispatcher->dispatch(new SendEmailToAllUnverifiedUsers($unverifiedUserWithinMonth));

        $this->cache->repository()
            ->put($this->cache->getCacheKey('admin-send-emails-once-per-day'), now(), now()->addDay());
    }
}