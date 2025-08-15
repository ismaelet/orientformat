<?php

namespace App\Http\Controllers;

use App\Helpers\ArrayHelper;
use App\Models\Activities\Section;
use Illuminate\Http\Request;
use Legacy\Activity\Section as LegacySection;

class SectionController extends Controller {

	function show(Section $section) {
		$legacySection = new LegacySection($section->id);

		$page = $legacySection->filePath . '/recap';
		$template = 'recap';
		$title = 'Riepilogo ' . $legacySection->name;

		// render
		\App\Legacy\LegacyView::setPage($page)
			->setTemplate($template)
			->setTitle($title)
			->set('section', $legacySection)
			->show();
	}
}
