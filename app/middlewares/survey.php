<?php

// OLD
/*
//redirect to survey if not completed yet
if (!$user->groupId && !DB::exists('survey_start WHERE userID=?', [$user->id])) redirect('/survey-start');
