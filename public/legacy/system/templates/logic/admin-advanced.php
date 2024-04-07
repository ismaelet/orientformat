<?php

/**
 * Setup
 */
$updated = $_GET['updated'] ?? false;
$added = $_GET['added'] ?? false;

/**
 * Page configuration
 */
$pageConfig = [
	'free' => false,
	'delete' => false,
	'preview-url' => null,
];
