<?php

namespace App\Listeners;

use App\Mail\VacancyDeletedPermanently;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailAboutPermanentDeletionOfVacancy implements ShouldQueue
{

    public $queue = 'low';

    public function handle(object $event): void
    {
        $employer = $event->actionDto->getActionableModel()->employer;

        Mail::to($employer->user->getEmail())->send(new VacancyDeletedPermanently($employer, $event->actionDto));
    }
}
