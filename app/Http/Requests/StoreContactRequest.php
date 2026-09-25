<?php

namespace App\Http\Requests;

use App\Services\RecaptchaVerifier;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $recaptcha = app(RecaptchaVerifier::class);

        return [
            'full_name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'company' => ['nullable', 'string', 'max:150'],
            'service' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'g-recaptcha-response' => [
                'bail',
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) use ($recaptcha): void {
                    if (! $recaptcha->verify($value, $this->ip())) {
                        $fail('La vérification reCAPTCHA a échoué. Veuillez réessayer.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'Veuillez confirmer que vous n’êtes pas un robot.',
        ];
    }
}
