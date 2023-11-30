<?php

// OLD
/*
function middleware_tester() {
	

	$classId = DB::find('classId FROM students WHERE userId=?', [$user->id]);

	if ($classId && DB::find('tester FROM classes WHERE id=?', $classId)) redirect(sysData('logged-redirect'));
}
