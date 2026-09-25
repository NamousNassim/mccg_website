<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecaptchaVerifier
{
    public function verify(string $token, ?string $ipAddress = null): bool
    {
        $secretKey = config('services.recaptcha.secret_key');
        $verifyUrl = config('services.recaptcha.verify_url');

        if (! is_string($secretKey) || trim($secretKey) === '' || ! is_string($verifyUrl) || trim($verifyUrl) === '') {
            Log::error('La configuration reCAPTCHA est incomplète.');

            return false;
        }

        $payload = [
            'secret' => $secretKey,
            'response' => $token,
        ];

        if ($ipAddress) {
            $payload['remoteip'] = $ipAddress;
        }

        try {
            $response = Http::acceptJson()
                ->asForm()
                ->timeout(5)
                ->post($verifyUrl, $payload);
        } catch (Throwable $exception) {
            Log::warning('La vérification reCAPTCHA est indisponible.', [
                'exception' => $exception->getMessage(),
            ]);

            return false;
        }

        if (! $response->successful()) {
            Log::warning('La vérification reCAPTCHA a retourné une erreur HTTP.', [
                'status' => $response->status(),
            ]);

            return false;
        }

        $verified = $response->json('success') === true;

        if (! $verified) {
            Log::notice('Une réponse reCAPTCHA a été refusée.', [
                'error_codes' => $response->json('error-codes', []),
            ]);
        }

        return $verified;
    }
}
