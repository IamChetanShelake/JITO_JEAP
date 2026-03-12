<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ThirdStageDocumentCorrectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $remark;

    public function __construct(User $user, string $remark)
    {
        $this->user = $user;
        $this->remark = $remark;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '3rd Stage Documents: Correction Required'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.third_stage_document_correction',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
