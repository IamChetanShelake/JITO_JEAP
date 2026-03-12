<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThirdStageDocumentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Carbon $secondDisbursementDate;

    public function __construct(User $user, Carbon $secondDisbursementDate)
    {
        $this->user = $user;
        $this->secondDisbursementDate = $secondDisbursementDate;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: Submit 3rd Stage Documents'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.third_stage_document_reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
