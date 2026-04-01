<?php

namespace App\Mail;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RepaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Carbon $repaymentDate;
    public float $installmentAmount;

    public function __construct(User $user, Carbon $repaymentDate, float $installmentAmount)
    {
        $this->user = $user;
        $this->repaymentDate = $repaymentDate;
        $this->installmentAmount = $installmentAmount;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: Upcoming Repayment Due'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.repayment_reminder'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
