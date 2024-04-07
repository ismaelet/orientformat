<?php

//template
$this->add_logic('main', 'template');
$this->styles->add(SERVER_ROOT . '/app/templates/styles/management-add.css');

load_module('form');

//logic
if (file_exists($file = SERVER_ROOT . '/pages/logic/' . $this->name . '.php')) include_once($file);

//setup variables
$done = false;
$error = false;
$id = $_GET['id'] ?? false;

//fetch data
if ($id) $row = $row ?? DBOld::row('* FROM ' . $tbl . ' WHERE ' . $index . ' = ?', [$id]);
else $row = false;

//add
if (isset($_POST['add'])) {

	if (function_exists('expand_add')) $error = expand_add($tbl, $inputs);
	else form_db_add($tbl, $inputs);

	if (!$error) {

		$done = true;
		unset($_POST);
	}
}

//edit
if (isset($_POST['edit'])) {

	if (function_exists('expand_edit')) $error = expand_edit($tbl, $inputs, $index, $id);
	else form_db_update($tbl, $inputs, $index, $id);

	if (!$error) header('Location: list');
}

//store variables
$this->set('row', $row);
$this->set('name', $name);
$this->set('edit', $id);
$this->set('done', $done);
$this->set('error', $error);
$this->set('title', $title);
$this->set('stitle_add', $stitle_add);
$this->set('stitle_edit', $stitle_edit);
$this->set('inputs', $inputs);
