<?php

// OLD
/*
function middleware_tester() {
	

	$classId = \System\Classes\DBOld::find('classId FROM students WHERE userId=?', [$user->id]);

	if ($classId && \System\Classes\DBOld::find('tester FROM classes WHERE id=?', $classId)) redirect_old(sysData('logged-redirect'));
}
