<?php

use Illuminate\Support\Facades\Auth;

// parse colors
function parse_rgba($hex, $alpha = 1) {
	$rgba = [];
	$hex = str_replace('#', '', $hex);

	for ($i = 0; $i < 3; $i++) $rgba[] = hexdec(substr($hex, $i * 2, 2));

	$rgba[] = $alpha;

	return $rgba;
}

/**
 * User functions
 */
function user() {
	if (Auth::id()) {
		\App\Legacy\ActiveUser::getInstance()->setId(Auth::id());
	}

	return \App\Legacy\ActiveUser::getInstance();
}

function logged() {
	return Auth::check();
}

function guest() {
	return !logged();
}

function admin() {
	return \App\Legacy\ActiveUser::getInstance()->isAdmin;
}

function manager() {
	return \App\Legacy\ActiveUser::getInstance()->isManager;
}
