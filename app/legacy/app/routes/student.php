<?php

use App\Helpers\ArrayHelper;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use \Legacy\Activity\Section as LegacySection;
use \Legacy\Activity\Test as LegacyTest;

// interests
\App\Legacy\LegacyRoute::add('/interest', function () {


    add_grade_style();

    return \App\Legacy\LegacyView::setPage('interest')
        ->setMiddlewares(['logged'])
        ->show();
});

// review
\App\Legacy\LegacyRoute::add('/review', function () {

    add_grade_style();

    return \App\Legacy\LegacyView::setPage('review')
        ->setMiddlewares(['public', 'student', 'logged', 'active', 'required-email'])
        ->show();
});
