<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activities\Area;
use App\Models\Activities\Section;
use Illuminate\Http\Request;

class StudentAnalysisController extends Controller {

	/**
	 * * Action: Show
	 */
	function show(?Area $area, ?Section $section) {
		if ($section->id) {
			$area = $section->area;
		}

		$page = $section->id ? $section->slug : ($area->id ? 'area-' . $area->slug : null);

		if (!$page) {
			return redirect()->back();
		}

		\App\Legacy\LegacyView::setPage('student-read/' . $page)
			->setTitle('Saperne di più')
			->setTemplate('student-read')
			->set('sectionId', $section->id)
			->set('areaId', $area->id)
			->show();
	}
}
