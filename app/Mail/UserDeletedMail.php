<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserDeletedMail extends Mailable
{

    use Queueable;
    use SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Temporarily deleted your account',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'auth.email.user-deleted',
        );
    }
}
