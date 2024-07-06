<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmEmail extends Mailable
{

    use Queueable, SerializesModels;

    public function __construct(protected int $code)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Email',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'auth.email.verify-email',
            with: [
                'code' => $this->code,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

}
