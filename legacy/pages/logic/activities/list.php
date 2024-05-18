<?php

use \Legacy\SchoolSystem\Grade as SchoolSystemGrade;
use LegacyModels\Activities\Grade;

$gradeNumber = $_GET['grade'] ?? 1;
$gradeNumber = max(1, min(8, $gradeNumber));
$gradeNumber = student()->isInHighschool && $gradeNumber < 4 ? 4 : $gradeNumber;
$gradeNumber = student()->isInMiddleschool && $gradeNumber > 3 ? 3 : $gradeNumber;
$gradeNumber = $gradeNumber > student()->schoolClass->currentGrade ? student()->schoolClass->currentGrade : $gradeNumber;
$grade = new SchoolSystemGrade($gradeNumber);
$gradeModel = new Grade(realGradeId($gradeNumber));

$_SESSION['activities-year'] = $gradeNumber;
