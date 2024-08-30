<?php

namespace App\Mail;

use App\Persistence\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class RestoreAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly User $user
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Restore Account',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'auth.email.restore-deleted-user',
            with: [
                'url' => $this->verificationUrl()
            ]
        );
    }

    public function verificationUrl(): string
    {
        return URL::signedRoute('deleted-user.restore', [
            'identity' => $this->user->user_id,
        ]);
    }
}
