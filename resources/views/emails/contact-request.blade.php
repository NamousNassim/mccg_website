<!doctype html>
<html lang="fr">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="margin:0;background:#f4f6f8;color:#1f2937;font-family:Arial,sans-serif">
<div style="max-width:640px;margin:0 auto;padding:24px 12px"><div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:28px">
    <h1 style="margin:0 0 24px;font-size:22px;color:#172033">Nouvelle demande de contact MCCG</h1>
    <table role="presentation" style="width:100%;border-collapse:collapse;font-size:15px;line-height:1.6">
        <tr><td style="width:145px;padding:5px 0;font-weight:bold;vertical-align:top">Nom</td><td style="padding:5px 0">{{ trim($contactMessage->first_name.' '.$contactMessage->last_name) }}</td></tr>
        <tr><td style="padding:5px 0;font-weight:bold;vertical-align:top">E-mail</td><td style="padding:5px 0">{{ $contactMessage->email }}</td></tr>
        <tr><td style="padding:5px 0;font-weight:bold;vertical-align:top">Téléphone</td><td style="padding:5px 0">{{ $contactMessage->phone ?: 'Non renseigné' }}</td></tr>
        <tr><td style="padding:5px 0;font-weight:bold;vertical-align:top">Entreprise</td><td style="padding:5px 0">{{ $contactMessage->company ?: 'Non renseignée' }}</td></tr>
        <tr><td style="padding:5px 0;font-weight:bold;vertical-align:top">Service</td><td style="padding:5px 0">{{ $contactMessage->service ?: 'Non précisé' }}</td></tr>
    </table>
    <h2 style="margin:24px 0 8px;font-size:16px;color:#172033">Message</h2>
    <div style="white-space:pre-wrap;border-left:3px solid #ef765f;padding:12px 16px;background:#f9fafb;line-height:1.65">{{ $contactMessage->message }}</div>
</div></div>
</body>
</html>
