<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Throwable;

class FailedJobNotifierToSuperAdmin extends Mailable
{

    use Queueable;
    use SerializesModels;

    public function __construct(
        private ?Throwable $throwable
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'ERROR!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'admin.mail.failed-job',
            with: [
                'message' => $this->throwable->getMessage(),
                'file' => $this->throwable->getFile(),
                'failedAt' => now()
            ]
        );
    }

}
