<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UrlScheme implements ValidationRule
{
    /**
     * @param string $key
     * @param string $scheme
     */
    public function __construct(protected string $key, protected string $scheme = 'https')
    {

    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_array($value)) {
            foreach ($value as $key => $_value) {
                if (is_array($_value) && isset($_value[$this->key])) {
                    $url = parse_url($_value[$this->key]);

                    if ($url['scheme'] !== $this->scheme) {
                        $fail(__('Media URL must use HTTPS.'));
                    }
                }
            }
        } else {
            $url = parse_url($value);
            if ($url['scheme'] !== $this->scheme) {
                $fail(__('Media URL must use HTTPS.'));
            }
        }
    }
}
