<?php

if (!function_exists('plugin')) {
    /**
     * @param string $path
     * @param bool   $version
     * @return string
     */
    function vendor(string $path, bool $version = false): string
    {
        $path = ltrim($path, '/');

        return asset("vendor/$path".($version ? '?v='.time() : null));
    }
}

if (!function_exists('css')) {
    /**
     * @param string $path
     * @param bool   $version
     * @return string
     */
    function css(string $path, bool $version = false): string {
        $path = ltrim($path, '/');

        return asset("css/$path".($version ? '?v='.time() : null));
    }
}

if (!function_exists('js')) {
    /**
     * @param string $path
     * @param bool   $version
     * @return string
     */
    function js(string $path, bool $version = false): string {
        $path = ltrim($path, '/');

        return asset("js/$path".($version ? '?v='.time() : null));
    }
}
