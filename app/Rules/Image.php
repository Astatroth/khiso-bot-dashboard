<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class Image implements ValidationRule
{
    use ValidatesAttributes;

    /**
     * @var array|string[]
     */
    protected string $mimes = 'jpg,jpeg,png,webp';

    /**
     * @param string|null $mimes
     * @param int         $size
     */
    public function __construct(string $mimes = null, protected int $size = 5)
    {
        if (!is_null($mimes)) {
            $this->mimes = $mimes;
        }
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            $fail('validation.file', ['attribute' => $attribute]);
        }

        if (!$this->validateMimes($attribute, $value, explode(',', $this->mimes))) {
            $fail('validation.mimes', ['attribute' => $attribute, 'values' => $this->mimes]);
        }

        if ($this->size > 0) {
            $filesize = filesize($value->path()) / 1000;
            $maxSize = $this->size * 1024;

            if ($filesize > $maxSize) {
                $fail('validation.size.file', ['attribute' => $attribute, 'size' => $this->size]);
            }
        }
    }
}
