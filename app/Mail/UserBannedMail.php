<?php

namespace App\Mail;

use App\DTO\Admin\AdminBannedUserDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserBannedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private AdminBannedUserDto $dto,
        private ?string $bannedUntil
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your account suspended',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'admin.mail.user-banned',
            with: [
                'name' => $this->dto->getActionableModel()->getFullName(),
                'reason' => $this->dto->getReasonForAction()->toString(),
                'description' => $this->dto->getReasonForAction()->description(),
                'comment' => $this->dto->getComment(),
                'duration' => $this->dto->getBanDurationEnum(),
                'bannedUntil' => $this->bannedUntil
            ],
        );
    }

}
