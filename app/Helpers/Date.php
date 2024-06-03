<?php

if (!function_exists('is_date')) {
    function is_date(mixed $x): bool
    {
        return $x instanceof \Illuminate\Support\Carbon && (date('Y-m-d H:i:s', strtotime($x)) == $x);
    }
}

if (!function_exists('beautify_month_name')) {
    function beautify_month_name($date, $format = 'd MMMM y'): string
    {
        $formatter = new IntlDateFormatter(
            \LaravelLocalization::getCurrentLocaleRegional(),
            IntlDateFormatter::LONG,
            IntlDateFormatter::LONG,
        );

        $formatter->setPattern($format);

        return $formatter->format($date);
    }
}
