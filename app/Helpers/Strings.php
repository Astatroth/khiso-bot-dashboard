<?php

if (!function_exists('is_json')) {
    /**
     * @param string $json
     * @return bool
     */
    function is_json(string $json): bool
    {
        json_decode($json);

        return json_last_error() === JSON_ERROR_NONE;
    }
}

if (!function_exists('slugify')) {
    /**
     * @param string         $string
     * @param string         $separator
     * @param string         $language
     * @param array|string[] $dictionary
     * @return string
     */
    function slugify(
        string $string,
        string $separator = '-',
        string $language = 'en',
        array $dictionary = ['@' => 'at']
    ): string
    {
        return Str::of($string)->slug($separator, $language, $dictionary);
    }
}
