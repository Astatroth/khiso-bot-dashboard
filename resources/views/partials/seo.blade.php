@if (isset($seo))
    @if ($seo->description)
        <meta name="description" content="{{ $seo->description }}">
    @endif

    @if ($seo->og_title)
        <meta property="og:title" content="{{ $seo->og_title }}">
    @endif
    @if ($seo->description)
        <meta property="og:description" content="{{ $seo->description }}">
    @endif
    @if ($seo->og_type)
        <meta property="og:type" content="{{ $seo->og_type }}">
    @endif
    @if ($seo->og_url)
        <meta property="og:url" content="{{ config('app.url').$seo->og_url }}">
    @endif
    @if ($seo->og_image)
        <meta property="og:image" content="{{ $seo->og_image->url }}">
    @endif
    <meta property="og:locale" content="{{ LaravelLocalization::getCurrentLocaleRegional() }}">
    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $data)
        @if ($locale !== app()->getLocale())
            <meta property="og:locale:alternate" content="{{ $data['regional'] }}">
        @endif
    @endforeach
    <meta property="og:site_name" content="{{ config('app.name') }}">
    @foreach (LaravelLocalization::getLocalesOrder() as $locale => $data)
        @if (isset($seo->content))
            @if ($seo->content->aliases->isNotEmpty())
                @php
                    $alias = $seo->content->aliases->filter(function ($i) use ($locale) {
                            return $i->language === $locale;
                        })->first();
                @endphp
                @if ($alias)
                    <link rel="alternate" hreflang="{{ $locale }}" href="{{ config('app.url').'/'.$locale.$alias->path }}">
                @endif
            @endif
        @endif
    @endforeach
@endif
