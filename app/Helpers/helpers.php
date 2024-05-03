<?php

use App\Helpers\EcommerceHelper;
use App\Helpers\FileHelper;
use App\Models\Ecommerce\Cart;
use Illuminate\Support\Facades\Auth;

/**
 * Check if the user is an admin
 */
function is_admin(): bool {
	return Auth::check() && Auth::user()->isAdmin();
}

/**
 * Check if the user is a supervisor
 */
function is_supervisor(): bool {
	return Auth::check() && Auth::user()->isSupervisor();
}

/**
 * Get the path of a file in the public storage directory
 */
function public_asset(string $path): string {
	return FileHelper::publicAsset($path);
}

/**
 * Get the path of a file in the public storage directory
 */
function public_storage_path(string $path): string {
	return FileHelper::publicStoragePath($path);
}

/**
 * Import an svg and embed it in the HTML
 */
function embed_svg(string $fileName, array $customClasses = []): ?string {
	return FileHelper::embedSvg($fileName, $customClasses);
}

/**
 * Import an icon and embed it in the HTML
 */
function embed_icon(string $fileName, array $customClasses = []): ?string {
	return FileHelper::embedSvg($fileName, $customClasses, true);
}

/**
 * Get the active cart
 */
function cart(): ?Cart {
	return EcommerceHelper::cart();
}

/**
 * Get the number of items in the cart
 */
function cart_quantity(): int {
	return EcommerceHelper::cartQuantity();
}


/**
 * ! Deprecated
 */
function camel_case_to_kebab_case(string $string): string {
	$result = preg_replace_callback('/[A-Z]/', function ($matches) {
		return '-' . strtolower($matches[0]);
	}, $string);

	return ltrim($result, '-');
}

function test_config($testId, $field) {
	global $testsConfig;

	include_once(base_path() . '/legacy/app/config/tests.php');

	return $testsConfig[$testId][$field] ?? false;
}

function section_config($sectionId, $field) {
	global $sectionsConfig;

	include_once(base_path() . '/legacy/app/config/sections.php');

	if (isset($sectionsConfig[$sectionId][$field])) {
		$value = $sectionsConfig[$sectionId][$field];
	} else {
		switch ($field) {
			case 'tiers':
				$value = ['Molto basso', 'Basso', 'Normale', 'Alto', 'Molto alto'];
				break;
			default:
				$value = false;
				break;
		}
	}

	return $value;
}

function percent($currentVal, $maxVal) {
	return $maxVal ? round($currentVal / $maxVal * 100) : 0;
}


function rows_to_objects(\System\Classes\Query_Result $rows = null, string $className) {
	$objects = [];

	while ($row = $rows->fetch_assoc()) {
		$objects[] = new $className($row[$className::INDEX]);
	}

	return $objects;
}
