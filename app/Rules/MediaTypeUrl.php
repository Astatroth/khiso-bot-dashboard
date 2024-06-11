<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MediaTypeUrl implements ValidationRule
{
    /**
     * @param string $key
     */
    public function __construct(protected array $types, protected string $key = 'src')
    {

    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $key => $_value) {
            if (isset($_value[$this->key])) {
                $extension = pathinfo($_value[$this->key], PATHINFO_EXTENSION);

                if (empty($extension)) {
                    $fail(__("Media URL must end with image/video extension."));
                }

                if ((int)$_value['type'] === $this->types['photo'] && $extension === 'mp4') {
                    $fail(__("Media of type 'photo' must not have 'mp4 extension.'"));
                }

                if ((int)$_value['type'] === $this->types['video'] && $extension !== 'mp4') {
                    $fail(__("Media of type 'video' must have 'mp4' extension."));
                }
            }
        }
    }
}
