<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Chapter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewStudentRegisteredForChapterMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Chapter $chapter;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Chapter $chapter)
    {
        $this->user = $user;
        $this->chapter = $chapter;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Student Registered - JITO JEAP',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.new_student_registered_for_chapter',
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