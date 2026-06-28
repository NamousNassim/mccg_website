<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageReceivedMail;
use App\Mail\NewContactMessageMail;
use App\Models\ContactMessage;
use App\Models\PageSeo;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function create()
    {
        return view('pages.contact', ['services' => Service::where('is_active', true)->get(), 'seo' => PageSeo::for('contact')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email:rfc', 'max:255'], 'phone' => ['nullable', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:150'], 'service' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);
        [$firstName, $lastName] = array_pad(explode(' ', trim($data['full_name']), 2), 2, '');
        $data['first_name'] = $firstName;
        $data['last_name'] = $lastName;
        unset($data['full_name']);
        $contactMessage = ContactMessage::create($data);

        try {
            Mail::to(config('mail.contact_notification'))->queue(new NewContactMessageMail($contactMessage));
        } catch (Throwable $exception) {
            Log::error('Impossible de mettre en file la notification administrateur du formulaire de contact.', [
                'contact_message_id' => $contactMessage->id,
                'exception' => $exception->getMessage(),
            ]);
        }

        try {
            Mail::to($contactMessage->email)->queue(new ContactMessageReceivedMail($contactMessage));
        } catch (Throwable $exception) {
            Log::error('Impossible de mettre en file l’accusé de réception du formulaire de contact.', [
                'contact_message_id' => $contactMessage->id,
                'exception' => $exception->getMessage(),
            ]);
        }

        return back()->with('success', 'Merci, votre message a bien été envoyé. Notre équipe vous recontactera rapidement.');
    }
}
