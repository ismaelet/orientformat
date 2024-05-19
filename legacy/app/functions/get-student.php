<?php

function get_student() {
	global $user, $student, $supervisorView;

	$student = $user;
	$supervisorView = false;

	if (isset($_GET['studentId'])) {
		$studentId = $_GET['studentId'];
		$watcherId = $user->id;

		if ($studentId != $watcherId) {
			$watcher = new Teacher($watcherId);

			if (in_array($studentId, $watcher->studentIds)) {
				$student = new \App\Legacy\User($studentId);
				$supervisorView = true;
			}
		}
	}
}
