<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $contactData)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [$this->contactData['email']],
            subject: 'Contact Form: ' . $this->contactData['subject'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-form-message',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
