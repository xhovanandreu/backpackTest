<?php

namespace App\Mail;

use App\Models\Classroom;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewClassroomNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $classroom;

    /**
     * Create a new message instance.
     */
    public function __construct(Classroom $classroom)
    {
        $this->classroom = $classroom;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Classroom Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            with: ['classroom' => $this->classroom],
            view: 'mail.classroomCreated',
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
