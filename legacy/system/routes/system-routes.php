<?php

/**
 * Ajax calls
 */
\Legacy\System\Classes\LegacyRoute::add('/ajax/*', function ($path) {
	$ajaxFile = null;
	$ajaxRequest = explode('ajax/', $path)[1] ?? null;
	$ajaxModule = explode('?', $ajaxRequest)[0] ?? null;

	if (file_exists($file = SERVER_ROOT . '/app/functions/ajax/' . $ajaxModule . '.php')) $ajaxFile = $file;
	else if (file_exists($file = SERVER_ROOT . '/system/functions/ajax/' . $ajaxModule . '.php')) $ajaxFile = $file;

	if ($ajaxFile) include_once($ajaxFile);
	else echo 'Error: invalid requested file';
});

/**
 * API calls
 */
// Function call
\Legacy\System\Classes\LegacyRoute::add('/api-old/call-function/*', function ($path) {
	$response = [];

	// request data
	$request = explode('call-function/', $path)[1] ?? null;
	$functionName = str_replace('/', '\\', explode('?', $request)[0]) ?? null;
	$arguments = isset($_GET['arguments']) ? (array) $_GET['arguments'] : [];

	$response = call_user_func($functionName, ...$arguments);

	echo json_encode($response);
});

// Search a table
\Legacy\System\Classes\LegacyRoute::add('/api-old/search-table/*', function ($path) {
	$response = [];
	$queryFilters = [];
	$queryParameters = [];

	// request data
	$request = explode('search-table/', $path)[1] ?? null;
	$table = str_replace('/', '\\', explode('?', $request)[0]) ?? null;
	$searchFields = explode(',', $_GET['searchFields']);
	$responseFields = explode(',', $_GET['responseFields']);
	$orderField = $_GET['orderField'] ?? null;
	$orderDirection = $_GET['orderDirection'] ?? 'DESC';
	$limit = $_GET['limit'] ?? 10;
	$search = $_GET['search'] ?? null;


	if ($search) {
		$querySelect = implode(', ', $responseFields);
		$queryOrder = $orderField;
		$queryOrderDirection = strtoupper($orderDirection);

		foreach ($searchFields as $searchField) {
			$queryFilters[] = 'LOWER(' . $searchField . ") LIKE CONCAT('%',?,'%')";
			$queryParameters[] = strtolower($search);
		}

		$queryFilters = implode(' OR ', $queryFilters);

		$query = $querySelect . ' FROM ' . $table . ' WHERE ' . $queryFilters . '  ORDER BY ' . $queryOrder . ' ' . $queryOrderDirection . ' LIMIT ' . $limit;

		$response = (\Legacy\System\Classes\LegacyDB::select($query, $queryParameters))->res;
	}

	echo json_encode($response);
});

// Class interactions
\Legacy\System\Classes\LegacyRoute::add(['/api-old/get-class-properties/*', '/api-old/call-class-method/*'], function ($path) {
	$response = [];

	if (empty($_POST)) {
		$_POST = json_decode(file_get_contents('php://input'), true);
	}

	// request data
	$requetType = strpos($path, 'properties') ? 'properties' : 'method';
	$className = str_replace('/', '\\', explode($requetType . '/', $path)[1]);
	$objectId = $_POST['objectId'] ?? null;
	$object = $objectId !== null ? new $className($objectId) : null;
	$scope = $_POST['scope'] ?? null;
	$arguments = $_POST['arguments'] ?? null;
	$setProperties = isset($_POST['setProperties']) ? explode(',', $_POST['setProperties']) : [];

	// set the properties
	foreach ($setProperties as $setProperty) {
		$setProperty = explode('=', $setProperty);
		$setMethod = 'set' . ucfirst($setProperty[0]);
		$setValue = $setProperty[1];

		if ($object) {
			$object->$setMethod($setValue);
		} else {
			$className::$setMethod($setValue);
		}
	}

	// get the response
	if ($requetType == 'properties') {
		// get properties
		$scope = explode(',', $scope);

		foreach ($scope as $propertyName) {
			if ($object) {
				$propertyValue = $object->$propertyName;
			} else {
				$propertyValue = $className::$propertyName;
			}

			$response[$propertyName] = $propertyValue;
		}
	} else {
		if ($object) {
			$response = $arguments ? $object->$scope(...$arguments) : $object->$scope();
		} else {
			$response = $arguments ? $className::$scope(...$arguments) : $className::$scope();
		}
	}

	echo json_encode($response);
});

/**
 * Favicon
 */
\Legacy\System\Classes\LegacyRoute::add('/favicon.ico', function () {
	include(SERVER_ROOT . '/app/assets/favicon/favicon.ico');
});
