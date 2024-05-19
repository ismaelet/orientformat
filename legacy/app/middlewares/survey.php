<?php

// OLD
/*
//redirect to survey if not completed yet
if (!$user->groupId && !\Legacy\System\Classes\LegacyDB::exists('survey_start WHERE userID=?', [$user->id])) redirect_old('/survey-start');
