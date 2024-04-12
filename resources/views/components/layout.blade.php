<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-color-scheme="{{ $colorScheme }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? $appDescription }}">
    <meta property="og:image" content="{{ asset('thumbnail.jpg') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>
        {{ isset($title) ? $title . ' | ' . $appName : $appName . ' | ' . config('custom.meta_data.short_description') }}
    </title>

    <link href="{{ mix('main.css') }}" rel="stylesheet">
    <script src="{{ mix('main.js') }}"></script>

    @stack('styles')

</head>

<body>
    {{ $slot }}
</body>

</html>
