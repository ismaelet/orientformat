<?php

use App\View\View;

/**
 * Get the path of a file relative to the server root
 */
function server_path(string $relativePath): string {
	return base_path() . '/legacy' . $relativePath;
}

/**
 * Get all the files in a folder
 */
function scan(string $path, string $extension = '*', string $filter = '*'): array {
	return glob(server_path($path . '/' . $filter . '.' . $extension));
}

/**
 * Get the url of an image
 */
function image_url(string $fileName): string {
	return client_path('/src/assets/images/' . ViewOld::name() . '/' . $fileName);
}

/**
 * Set the style: background-image property
 */
function set_background_image(string $fileName): string {
	return 'style="background-image: url(' . image_url($fileName) . ')"';
}
