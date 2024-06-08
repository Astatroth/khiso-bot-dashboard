<?php

namespace App\Http\Requests\Auth;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Propaganistas\LaravelPhone\Rules\Phone;

class SignInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'email' => 'required_without:phone',
            'phone' => [
                'required_without:email',
                (new Phone())->international()->mobile()->country(request()->phone_country)
            ],
            'password' => 'required'
        ];

        if (config('recaptcha.api_site_key')) {
            $rules['g-recaptcha-response'] = [
                'required', new Recaptcha()
            ];
        }

        return $rules;
    }
}
