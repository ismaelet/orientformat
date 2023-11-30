<?php

/* OLD
function middleware_teacher() {
	global $user, $teacher;

	$teacher = new Teacher($user->id);

	if (!$teacher->id) redirect('');
}

function middleware_class() {
	global $user, $grade;

	$gradeId = false;

	if (isset($_GET['classid'])) {
		$gradeId = $_SESSION['dashboard-schoolClassId'] = $_GET['classid'];
	} else if (isset($_SESSION['dashboard-schoolClassId'])) {
		$gradeId = $_SESSION['dashboard-schoolClassId'];
	}

	if ($user->groupId != 1) redirect('');
	if (!$gradeId || !DB::exists('teachers WHERE userId=? AND FIND_IN_SET (?, classes)', [$user->id, $gradeId])) redirect('/teacher');

	$grade = new Grade($gradeId);
}

function middleware_active() {

	if (!$user->groupId && !$user->status) redirect('/wait');
}

function middleware_manager() {

	if ($user->groupId != 2) redirect('/');
}

function middleware_student() {

	if ($user->groupId) redirect('/');
}

function middleware_required_email() {

	if (!$user->email) redirect('/add-email');
}

function middleware_beginner_review() {


	if (
		!$user->groupId &&
		!DB::exists('review_results WHERE studentId=? AND reviewId IN (1,2)', [$user->id]) &&
		!DB::exists('users WHERE id=? AND time<"2022-09-24"', [$user->id])
	) {
		$student = new UserSystem\Student($user->id);
		$reviewId = $student->schoolClass->schoolClass == 3 ? 2 : 1;
		redirect('/review?id=' . $reviewId);
	}
}

function middleware_end_review() {
	/*

	if (
		!$user->groupId &&
		!DB::exists('review_results WHERE studentId=? AND reviewId = 3', [$user->id]) &&
		!DB::exists('users WHERE id=? AND time<"2022-09-24"', [$user->id])
	) {
		$student = new UserSystem\Student($user->id);

		if ($student->schoolClass->ended) redirect('/review?id=3');
	}*
}

function middleware_tester() {


	$classId = DB::find('classId FROM students WHERE userId=?', [$user->id]);

	if ($classId && DB::find('tester FROM classes WHERE id=?', $classId)) redirect(sysData('logged-redirect'));
}
*/