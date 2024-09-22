<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ConfirmAdminEmailChanging extends Mailable
{

    use Queueable;
    use SerializesModels;

    public function __construct(
        private string $id,
        private string $newEmail
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Email Changing',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'admin.mail.confirm-change',
            with: [
                'url' => $this->temporarilyUrl()
            ]
        );
    }

    protected function temporarilyUrl(): string
    {
        return URL::temporarySignedRoute('admin.confirm-email-change', now()->addHour(), [
            'id' => $this->id,
            'email' => $this->newEmail
        ]);
    }
}
