<x-mail::message>
# Nouvelle demande de contact

Une nouvelle demande a été enregistrée depuis le site MCCG.

<x-mail::panel>
**Nom complet :** {{ trim($contactMessage->first_name.' '.$contactMessage->last_name) }}  
**E-mail :** {{ $contactMessage->email }}  
**Téléphone :** {{ $contactMessage->phone ?: 'Non renseigné' }}  
**Société :** {{ $contactMessage->company ?: 'Non renseignée' }}  
**Service demandé :** {{ $contactMessage->service ?: 'Non précisé' }}  
**Date de réception :** {{ $contactMessage->created_at->translatedFormat('d F Y à H:i') }}
</x-mail::panel>

## Message

{{ $contactMessage->message }}

<x-mail::button :url="url('/admin/contact-messages/'.$contactMessage->id.'/view')">
Consulter la demande
</x-mail::button>

Cet e-mail a été envoyé automatiquement par le site MCCG.
</x-mail::message>
