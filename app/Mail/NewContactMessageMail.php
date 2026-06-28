<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class NewContactMessageMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage)
    {
        $this->afterCommit();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->contactMessage->email, trim($this->contactMessage->first_name.' '.$this->contactMessage->last_name))],
            subject: 'Nouvelle demande de contact — MCCG',
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.new-contact-message');
    }

    public function attachments(): array
    {
        return [];
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Échec de la notification administrateur pour un message de contact.', [
            'contact_message_id' => $this->contactMessage->id,
            'exception' => $exception->getMessage(),
        ]);
    }
}
