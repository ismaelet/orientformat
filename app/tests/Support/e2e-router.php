<?php

// Router for `php -S`: serve static files directly, everything else via Laravel.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path !== '/' && is_file($_SERVER['DOCUMENT_ROOT'].$path)) {
    return false;
}

require __DIR__.'/e2e-index.php';
