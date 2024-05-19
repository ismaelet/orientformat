<?php

//template
$this->add_logic('main', 'template');
$this->styles->add(SERVER_ROOT . '/app/templates/styles/management-list.css');
$this->scripts->add(SERVER_ROOT . '/app/templates/scripts/management-list.js');

//page logic
if (file_exists($file = SERVER_ROOT . '/pages/logic/' . $this->name . '.php')) include_once($file);

//setup variables
$actions = $actions ?? false;
$back = $back ?? false;
$searchSQL = $searchSQL ?? ['', []];
$search_bar = $search_bar ?? true;

//fetch data
$res = $res ?? \Legacy\System\Classes\LegacyDB::select('* FROM ' . $tbl . ' WHERE status=1 ' . $searchSQL[0] . ' ORDER BY ' . $index . ' DESC LIMIT 50', $searchSQL[1]);

$list = [];

while ($row = $res->fetch_assoc()) $list[] = $row;

//delete entry
if (isset($_POST['delete'])) {

	\Legacy\System\Classes\LegacyDB::update($tbl . ' SET status=0 WHERE ' . $index . ' = ?', [$_POST[$index]]);

	redirect_old();
}

//download list
if (isset($_POST['download'])) {

	$array = [];

	foreach ($list as $entry) {

		$line = [];

		foreach ($fields as $field) {

			$type = $field['type'] ?? 'text';
			$switch = $field['switch'] ?? false;
			$switch_file = $field['switch_file'] ?? $switch;

			if ($type == 'text') $line[$field['title']] = $field['value'] ?? $entry[$field['name']];
			else if ($type == 'find') {

				$val = \Legacy\System\Classes\LegacyDB::find($field['find'][0], $entry[$field['find'][1]]);

				if ($switch_file) $val = empty($val) ? $field['switch_file'][1] : $field['switch_file'][0];
				if (isset($field['parse']) && $field['parse'] == 'int') $val = (int) $val;

				$line[$field['title']] = $val;
			}
		}

		$array[] = $line;
	}

	$title_file = $title_file ?? $title;

	download_csv($array, str_replace(' ', '_', $title_file) . '_' . date('Y-m-d'));
}

//store variables
$this->set('title', $title);
$this->set('back', $back);
$this->set('index', $index);
$this->set('fields', $fields);
$this->set('list', $list);
$this->set('actions', $actions);
$this->set('search_bar', $search_bar);
