<?php

namespace App\Mail;

use App\Contracts\Admin\AdminLogActionDtoInterface;
use App\Persistence\Models\Employer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VacancyDeletedPermanently extends Mailable
{

    use Queueable;
    use SerializesModels;

    public function __construct(
        private Employer $employer,
        private AdminLogActionDtoInterface $actionDto
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We delete your vacancy',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'admin.mail.permanent-delete-vacancy',
            with: [
                'name' => $this->actionDto->getActionableModel()->employer->company_name,
                'reason' => $this->actionDto->getReasonForAction()->toString(),
                'description' => $this->actionDto->getReasonForAction()->description(),
                'comment' => $this->actionDto->getComment()
            ]
        );
    }

}
