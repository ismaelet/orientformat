<?php

/**
 * Page configuration
 */

use \Legacy\SchoolSystem\SchoolClass;
use LogicManager\AdminLogic;

$pageConfig['add'] = false;
// $pageConfig['row-action'] = 'add?id={{id}}';

/**
 * Query configuration
 */
$queryConfig['table'] = 'school_classes';
$queryConfig['index'] = 'id';
$queryConfig['select'] = ['school_classes.id', 'CONCAT(firstName, " ", lastName) as referentName', 'schools.name as schoolName', 'code', 'startingYear', 'grade'];

$queryConfig['from'] = 'school_classes
INNER JOIN schools
ON school_classes.schoolId = schools.id
INNER JOIN users
ON school_classes.referentId = users.id';

$queryConfig['where-search'] = "school_classes.id = ? OR CONCAT(grade, letter) = ? OR schools.name LIKE CONCAT('%',?,'%') OR firstName LIKE CONCAT('%',?,'%') OR lastName LIKE CONCAT('%',?,'%') OR CONCAT(firstName, ' ', lastName) LIKE CONCAT('%',?,'%') OR CONCAT(lastName, ' ', firstName) LIKE CONCAT('%',?,'%')";

// select fields
$fields = [
	['title' => 'ID', 'name' => 'id', 'size' => 1],
	['title' => 'Nome', 'name' => 'grade', 'size' => 1],
	['title' => 'Anno scolastico', 'name' => 'startingYear', 'size' => 2],
	['title' => 'Istituto', 'name' => 'schoolName', 'size' => 4],
	['title' => 'Codice della classe', 'name' => 'code', 'size' => 2],
	['title' => 'Referente', 'name' => 'referentName', 'size' => 3,],
];

AdminLogic::$listResultConfiguration = function ($entry, $key, $field, $queryRow) {
	$schoolClass = new SchoolClass($queryRow['id']);

	switch ($field['name']) {
		case 'grade':
			$entry['value'] = $schoolClass->name;
			break;
		case 'startingYear':
			$entry['value'] = $schoolClass->yearRangeString;
			break;
	}

	return $entry;
};
