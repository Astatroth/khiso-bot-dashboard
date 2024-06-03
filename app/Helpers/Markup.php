<?php


use App\Models\Page\Page;
use App\Services\AliasService;
use App\Services\Structure\Block\BlockService;

if (!function_exists('mark_active')) {
    /**
     * @param string $pattern
     * @return string|null
     */
    function mark_active(string $pattern): string|null
    {
        return request()->route()->named($pattern) ? 'active' : null;
    }
}

if (!function_exists('flag')) {
    /**
     * @param string $locale
     * @return string
     */
    function flag(string $locale): string
    {
        return LaravelLocalization::getSupportedLocales()[$locale]['flag'] ?? $locale;
    }
}

if (!function_exists('render_block')) {
    function render_block(string $slug)
    {
        return view('block.render', [
            'block' => (new BlockService())->parseBlock($slug)
        ]);
    }
}

if (!function_exists('l')) {
    function l(string $path): string
    {
        $service = new AliasService();
        $link = $path;
        $parts = explode('/', ltrim($path, '/'));
        $contentType = null;

        if (isset($parts[1])) {
            switch ($parts[0]) {
                case 'page':
                    $contentType = Page::class;
                    break;
                default:
                    break;
            }

            if ($contentType) {
                if (is_numeric($parts[1])) {
                    $alias = $service->findByContentType($contentType, $parts[1]);
                    if (!is_null($alias)) {
                        $link = $alias->path;
                    }
                }
            }
        }

        return $link;
    }
}
