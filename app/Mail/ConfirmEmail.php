<?php

namespace App\Mail;

use App\Persistence\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ConfirmEmail extends Mailable
{

    use Queueable, SerializesModels;

    public function __construct(protected User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Email',
        );
    }

    public function content(): Content
    {
        $verifiedUrl = $this->verificationUrl();

        return new Content(
            markdown: 'auth.email.verify-email',
            with: [
                'verificationUrl' => $verifiedUrl,
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

    public function verificationUrl(): string
    {
        return URL::signedRoute('verification.verify', [
            'user_id' => $this->user->user_id,
            'hash' => sha1($this->user->getEmailForVerification()),
        ]);
    }

}
