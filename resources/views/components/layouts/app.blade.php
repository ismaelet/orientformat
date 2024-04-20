@props(['title' => null, 'theme' => 'classic', 'colorScheme' => null])

@php
    $appName = config('app.name');
    $appDescription = config('custom.meta_data.description');

    $title = $title ? $title . ' | ' . $appName : $appName . ' | ' . config('custom.meta_data.short_description');

    if (!$colorScheme) {
        $colorScheme =
            env('APP_DYNAMIC_COLOR_SCHEME') == 'true' &&
            isset($_COOKIE['color-scheme']) &&
            in_array($_COOKIE['color-scheme'], ['light', 'dark'])
                ? $_COOKIE['color-scheme']
                : config('custom.meta_data.default_color_scheme');
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-color-scheme="{{ $colorScheme }}"
    data-theme="{{ $theme }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? $appDescription }}">
    <meta property="og:image" content="{{ asset('thumbnail.jpg') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>
        {{ $title }}
    </title>

    <link href="{{ mix('main.css') }}" rel="stylesheet">
    <script src="{{ mix('main.js') }}"></script>
    @stack('styles')
    @stack('scripts')

</head>

<body>
    {{ $slot }}

    <livewire:scripts />
</body>

</html>
