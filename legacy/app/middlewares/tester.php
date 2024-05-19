<?php

// OLD
/*
function middleware_tester() {
	

	$classId = \Legacy\System\Classes\LegacyDB::find('classId FROM students WHERE userId=?', [$user->id]);

	if ($classId && \Legacy\System\Classes\LegacyDB::find('tester FROM classes WHERE id=?', $classId)) redirect_old(sysData('logged-redirect'));
}
