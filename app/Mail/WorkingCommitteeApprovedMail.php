<?php

namespace App\Mail;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WorkingCommitteeApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $applicationYear;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->applicationYear = date('Y');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "EF Asst.JITO-JEAP/{$this->applicationYear}/{$this->user->id} Your Application Approved by Working Committee",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.working_committee_approved',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        // Load all related data
        $this->user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        
        $educationDetail = $this->user->educationDetail;
        $workingCommitteeApproval = $this->user->workingCommitteeApproval;

        if (!$workingCommitteeApproval) {
            return [];
        }

        // Generate the sanction letter PDF
        $pdf = Pdf::loadView('pdf.jeap-sanction-letter', [
            'user' => $this->user,
            'educationDetail' => $educationDetail,
            'workingCommitteeApproval' => $workingCommitteeApproval,
        ]);

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                'Sanction_Letter_' . $this->user->name . '_' . $this->user->id . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
