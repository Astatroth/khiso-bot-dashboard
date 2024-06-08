<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = [
            'secret' => config('recaptcha.api_secret_key'),
            'response' => $value
        ];

        try {
            $validationRequest = curl_init();
            curl_setopt($validationRequest, CURLOPT_URL,
                "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($validationRequest, CURLOPT_POST, true);
            curl_setopt($validationRequest, CURLOPT_POSTFIELDS,
                http_build_query($data));
            curl_setopt($validationRequest, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($validationRequest, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($validationRequest);
        } catch (\Exception $e) {
            $fail('validation.recaptcha');
        }
    }
}
