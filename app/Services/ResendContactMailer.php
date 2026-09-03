<?php

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ResendContactMailer
{
    public function send(ContactMessage $contactMessage): void
    {
        $key = config('services.resend.key');
        $to = config('services.resend.contact.to');
        $fromEmail = config('services.resend.contact.from_email');
        $fromName = config('services.resend.contact.from_name');

        if (! $key || ! $to || ! $fromEmail) {
            throw new RuntimeException('Contact email configuration is incomplete.');
        }

        $subject = $contactMessage->service
            ? "Nouvelle demande MCCG — {$contactMessage->service}"
            : 'Nouvelle demande de contact — MCCG';

        $this->client($key)->post('https://api.resend.com/emails', [
            'from' => sprintf('%s <%s>', $fromName, $fromEmail),
            'to' => [$to],
            'reply_to' => $contactMessage->email,
            'subject' => $subject,
            'html' => view('emails.contact-request', compact('contactMessage'))->render(),
        ])->throw();
    }

    protected function client(string $key): PendingRequest
    {
        return Http::acceptJson()->asJson()->withToken($key)->timeout(15)->retry(2, 250);
    }
}
