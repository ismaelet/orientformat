<?php

define('INSTAGRAM_APP_ID', '586804842971911');
define('INSTAGRAM_APP_SECRET', '9cc4fc9f496973f65727df75f2523c19');

// request code
function vendor_instagram_request_code() {
	$endpoint = 'https://www.instagram.com/oauth/authorize/';
	$requestParameters = [
		'client_id' => INSTAGRAM_APP_ID,
		'client_secret' => INSTAGRAM_APP_SECRET,
		'redirect_uri' => __CLIENT_URL__ . '/instagram-auth',
		'scope' => 'user_profile,user_media',
		'response_type' => 'code',
	];

	new HttpResponse('REDIRECT', $endpoint, $requestParameters);
}

// exchange the code for a short-lived token
function vendor_instagram_exchange_code_for_token($code) {
	$token = false;
	$endpoint = 'https://api.instagram.com/oauth/access_token';
	$requestParameters = [
		'client_id' => INSTAGRAM_APP_ID,
		'client_secret' => INSTAGRAM_APP_SECRET,
		'code' => $code,
		'grant_type' => 'authorization_code',
		'redirect_uri' => __CLIENT_URL__ . '/instagram-auth',
	];

	$response = new HttpResponse('POST', $endpoint, $requestParameters);
	$responseJson = $response->json();

	if (!empty($responseJson['access_token'])) {
		$token = $responseJson['access_token'];
		$token = vendor_instagram_extend_token($token);
	} else {
		debug(['error' => 'Error exchanging a code for a token', $response]);
	}

	return $token;
}

// exchange the short-lived token for a long-lived token
function vendor_instagram_extend_token($shortLivedToken) {
	$longLivedToken = false;
	$endpoint = 'https://graph.instagram.com/access_token';
	$requestParameters = [
		'grant_type' => 'ig_exchange_token',
		'client_secret' => INSTAGRAM_APP_SECRET,
		'access_token' => $shortLivedToken
	];

	$response = new HttpResponse('GET', $endpoint, $requestParameters);
	$responseJson = $response->json();

	if (!empty($responseJson['access_token'])) {
		$longLivedToken = $responseJson['access_token'];
	} else {
		debug(['error' => 'Error extending a token life', $response]);
	}

	return $longLivedToken;
}

// refresh the long-lived token
function vendor_instagram_refresh_token() {
	$token = false;
	$oldToken = DB::find('value FROM config WHERE name="instagramToken"');
	$endpoint = 'https://graph.instagram.com/refresh_access_token';
	$requestParameters = [
		'grant_type' => 'ig_refresh_token',
		'access_token' => $oldToken
	];

	$response = new HttpResponse('GET', $endpoint, $requestParameters);
	$responseJson = $response->json();

	if (isset($responseJson['access_token'])) {
		$token = $responseJson['access_token'];
		DB::update('config SET value=? WHERE name="instagramToken"', [$token]);
		DB::update('config SET value=NOW() WHERE name="instagramTokenTime"');
	} else {
		debug(['error' => 'Error refreshing a token', $response]);
	}

	return $token;
}
