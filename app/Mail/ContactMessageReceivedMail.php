<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ContactMessageReceivedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage)
    {
        $this->afterCommit();
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Nous avons bien reçu votre demande — MCCG');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.contact-message-received');
    }

    public function attachments(): array
    {
        return [];
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Échec de l’accusé de réception d’un message de contact.', [
            'contact_message_id' => $this->contactMessage->id,
            'exception' => $exception->getMessage(),
        ]);
    }
}
