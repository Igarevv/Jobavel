<?php

namespace App\Mail;

use App\Persistence\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NeedToVerifyEmailOrAccountWillDeleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private User $user
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Please, verify email',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'auth.email.verify-or-die',
            with: [
                'url' => $this->verificationUrl()
            ]
        );
    }

    public function verificationUrl(): string
    {
        return URL::signedRoute('verification.verify', [
            'user_id' => $this->user->user_id,
            'hash' => sha1($this->user->getEmailForVerification()),
        ]);
    }
}
