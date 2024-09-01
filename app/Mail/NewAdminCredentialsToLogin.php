<?php

namespace App\Mail;

use App\Persistence\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewAdminCredentialsToLogin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private Admin $admin,
        private string $tempPassword
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'auth.email.new-admin',
            with: [
                'name' => $this->admin->first_name,
                'password' => $this->tempPassword,
                'email' => $this->admin->email
            ]
        );
    }
}
