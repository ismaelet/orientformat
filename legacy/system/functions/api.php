<?php

function API_GET($className, $requestContent, $id = false, $ids = []) {
	//setup request
	$response = [];
	$scope = isset($requestContent['scope']) ? explode(',', $requestContent['scope']) : ['id'];

	if ($id) {
		/*
		* Search for one result
		*/
	} else {
		/*
		* Search for a list of results
		*/
		foreach ($ids as $id) {
			$data = [];
			$design = new $className($id);

			foreach ($scope as $field) $data[$field] = $design->$field;

			$response[] = $data;
		}
	}

	//return response
	return $response;
}


function API_GET_ids($requestContent, $queryFields, $tbl, $idName = 'id') {

	// setup request
	$ids = [];
	$queryFields = 'WHERE ' . implode(' || ', $queryFields);
	$queryValues = [];
	$queryLimit = '';

	if (isset($requestContent['limit'])) $queryLimit = 'LIMIT ' . $requestContent['limit'];

	$query = $idName . ' FROM ' . $tbl . ' ' . $queryFields . ' ' . $queryLimit;

	for ($i = 1; $i <= substr_count($query, '?'); $i++) $queryValues[] = $requestContent['search'];

	$spreadQueryValues = [];

	foreach ($queryValues as $queryValue) $spreadQueryValues[] = $queryValue;

	$response = \App\Legacy\LegacyDB::select($query, [$spreadQueryValues]);

	while ($row = $response->fetch_assoc()) $ids[] = $row[$idName];

	return $ids;
}
