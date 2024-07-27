<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClearOutdatedContactEmailVerificationRequests extends Command
{

    protected $signature = 'verification:clear-outdated-requests';


    protected $description = 'Command clears outdated requests to verify contact email';


    public function handle(): void
    {
        Log::info('clear db');
        DB::table('verification_codes')->whereDate('created_at', '<', Carbon::now()->subHour())->delete();
    }
}
