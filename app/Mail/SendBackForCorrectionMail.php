<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendBackForCorrectionMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $rejectRemark;
    public ?float $financialAssistanceAmount;
    public string $applicationYear;

    

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $rejectRemark)
    {
        $this->user = $user;
        $this->rejectRemark = $rejectRemark;
        $this->applicationYear = date('Y');
        

        // Fetch financial assistance amount from education_details table (group_4_total column)
        $educationDetail = $user->educationDetail;
        $this->financialAssistanceAmount = $educationDetail
            ? $educationDetail->group_4_total
            : null;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "EF Asst.JITO-JEAP/{$this->applicationYear}/{$this->user->id} Request from {$this->user->name} Send For Correction",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.send_back_for_correction',
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
}
