<?php

// OLD
/*
$student = $user->id;
$watcher = false;

if (isset($_GET['user'])) {

	//get student
	$userID = $_GET['user'];

	//fetch class and check that the user is a teacher of that class
	$grade = \System\Classes\DBOld::find('class FROM users WHERE id=? AND level=1', [$user->id]);

	//if teacher and student both exists and are of that class
	if ($grade && \System\Classes\DBOld::exists('users WHERE class=? AND id=?', [$grade, $userID])) {

		$student = $userID;

		$watcher = true;

		$test = $view->get('test');

		$view->set('section', new \Legacy\Activity\Section($_GET['id'], $student));
		$view->set('test', new \Legacy\Activity\Test($test->step, $student));
	}
}

//store variables
$view->set('student', $student);
$view->set('watcher', $watcher);
