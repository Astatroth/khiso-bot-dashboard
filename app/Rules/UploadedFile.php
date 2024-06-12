<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UploadedFile implements ValidationRule
{
    /**
     * @var int
     */
    protected int $size = 5;

    /**
     * @param int|null $size
     */
    public function __construct(int $size = null)
    {
        if (!is_null($size)) {
            $this->size = $size;
        }
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof \Illuminate\Http\UploadedFile) {
            $fail(__('validation.file', ['attribute' => $attribute]));
        }

        if ($this->size > 0) {
            $filesize = filesize($value->path()) / 1000;
            $maxSize = $this->size * 1024;

            if ($filesize > $maxSize) {
                $fail(__('validation.size.file', ['attribute' => $attribute, 'size' => $this->size]));
            }
        }
    }
}
