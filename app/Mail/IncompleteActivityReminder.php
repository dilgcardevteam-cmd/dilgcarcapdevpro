<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Course;
use App\Models\User;

class IncompleteActivityReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $course;
    public $participant;
    public $incompleteActivities;

    /**
     * Create a new message instance.
     */
    public function __construct(Course $course, User $participant, array $incompleteActivities)
    {
        $this->course = $course;
        $this->participant = $participant;
        $this->incompleteActivities = $incompleteActivities;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: Pending Activities in ' . $this->course->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.incomplete_reminder',
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
