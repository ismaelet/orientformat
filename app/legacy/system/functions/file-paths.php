<?php

/*
* File url
*/

function public_client_path(?string $file = '') {
    if (defined('PUBLIC_CLIENT_ROOT')) {
        $url = PUBLIC_CLIENT_ROOT . file_time(generate_base_url($file), true);
    } else {
        $url = client_path($file);
    }

    return $url;
}

function public_server_directory(string $path = '') {
    if (defined('PUBLIC_SERVER_ROOT')) {
        $url = PUBLIC_SERVER_ROOT . $path;
    } else {
        $url = SERVER_ROOT . $path;
    }

    return $url;
}

/*
* Links
*/
function public_client_url(string $parcialUrl = '') {
    if (defined('PUBLIC_CLIENT_ROOT')) {
        $url = PUBLIC_CLIENT_ROOT . $parcialUrl;
    } else {
        $url = client_url($parcialUrl);
    }

    return $url;
}

function temp_bg($img) {
    return 'style="background-image: url(' . asset('storage/' . $img) . ');"';
}

// put a svg as background image
function img_svg($img) {
    return 'style="mask: url(' . client_path($img) . '); -webkit-mask: url(' . client_path($img) . ') center;"';
}

// parse a url from server url to client url
function parse_html($url, $full = true) {
    $url = str_replace("\\", "/", $url);

    if (strpos($url, SERVER_ROOT) !== false) $url = $full ? CLIENT_ROOT . '/' . substr($url, strlen(SERVER_ROOT) + 1) : '/' . substr($url, strlen(SERVER_ROOT) + 1);

    return $url;
}

// parse a url from client url to server url
function parse_server_path($url) {
    if (strpos($url, CLIENT_ROOT) !== false) $url = SERVER_ROOT . explode(CLIENT_ROOT, $url)[1];
    return $url;
}

// get all files in the subfolders of a folder
function scans($path, $ext = '*') {
    $files = [];

    foreach (glob(SERVER_ROOT . $path . '/*', GLOB_ONLYDIR) as $dir) array_push($files, ...scan($dir, $ext));

    return $files;
}

// inlcude a file if it exits
function try_include(string $filePath) {
    if (file_exists($filePath)) {
        include($filePath);
    }
}

// get the server root
function force_base_url(string $filePath) {
    return strpos($filePath, SERVER_ROOT) !== false ? explode(SERVER_ROOT, $filePath)[1] : $filePath;
}

// get the public server root
function public_server_root() {
    return server_root();
}
