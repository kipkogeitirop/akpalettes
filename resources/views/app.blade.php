@php($seo = $page['props']['seo'] ?? null)
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#f6f1e9">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="icon" href="/favicon.ico" sizes="32x32">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @if ($seo)
            <title data-inertia>{{ $seo['title'] }}</title>
            <meta data-inertia="description" name="description" content="{{ $seo['description'] }}">
            <meta data-inertia="robots" name="robots" content="index, follow, max-image-preview:large">
            <link data-inertia="canonical" rel="canonical" href="{{ $seo['canonical'] }}">
            <meta data-inertia="og:site_name" property="og:site_name" content="{{ $seo['siteName'] }}">
            <meta data-inertia="og:type" property="og:type" content="{{ $seo['type'] }}">
            <meta data-inertia="og:title" property="og:title" content="{{ $seo['title'] }}">
            <meta data-inertia="og:description" property="og:description" content="{{ $seo['description'] }}">
            <meta data-inertia="og:url" property="og:url" content="{{ $seo['canonical'] }}">
            <meta data-inertia="og:image" property="og:image" content="{{ $seo['image'] }}">
            <meta data-inertia="og:image:alt" property="og:image:alt" content="{{ $seo['imageAlt'] }}">
            <meta data-inertia="twitter:card" name="twitter:card" content="summary_large_image">
            <meta data-inertia="twitter:title" name="twitter:title" content="{{ $seo['title'] }}">
            <meta data-inertia="twitter:description" name="twitter:description" content="{{ $seo['description'] }}">
            <meta data-inertia="twitter:image" name="twitter:image" content="{{ $seo['image'] }}">
            <script data-inertia="schema" type="application/ld+json">{!! json_encode($seo['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
        @else
            <title data-inertia>AK PALETTES</title>
            <meta data-inertia="robots" name="robots" content="noindex, nofollow">
        @endif
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html>
