<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(protected int $code)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify your contact email',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'account.verification-code',
            with: [
                'code' => $this->code,
            ]
        );
    }

}
