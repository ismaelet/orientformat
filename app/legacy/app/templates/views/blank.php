<!doctype html>
<html data-theme="light" data-client-root="/<?php

use App\Legacy\LegacyView;
use App\Legacy\ScriptLoader;
use App\Legacy\StyleLoader;
use Illuminate\Foundation\Vite;

?><?= env('APP_SUBDOMAIN') ?>" data-school-group="<?= is_student() ? (auth()->user()->isHighSchoolStudent() ? 'highschool' : 'middleschool') : 'none' ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <meta name="description" content="<?= LegacyView::getDescription() ?>">
    <title><?= LegacyView::getTabTitle() ?></title>
    <meta property="og:description" content="<?= LegacyView::getDescription() ?>">
    <link rel="icon" href="<?= asset('favicon.ico') ?>">

    <!-- Styles -->
    <link href="<?= asset('css/old-legacy.css').'?v='.filemtime(base_path().'/public/css/old-legacy.css') ?>" rel="stylesheet" type="text/css">
    <?= PHP_EOL.StyleLoader::load() ?>
    <?= PHP_EOL.StyleLoader::loadInline() ?>

    <!-- Scripts -->

    <?= app(Vite::class)('resources/js/app.ts') ?>
    <?= PHP_EOL.ScriptLoader::load() ?>

    <!-- Google tag (gtag.js) -->
    <?php if (env('APP_ENV') == 'production') { ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-8WZ7THPZ57"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-8WZ7THPZ57');
        </script>
    <?php } ?>

    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>
    {% place body %}

    <script defer src="https://cdn.jsdelivr.net/npm/leader-line-new@1.1.9/leader-line.min.js"></script>

    <?= ScriptLoader::loadFootInline() ?>
</body>

</html>
