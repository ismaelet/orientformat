<?php

namespace App\Http\Controllers\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\Http\Request;
use Legacy\Activity\Section as LegacySection;

class GraphController extends Controller {

	/**
	 * Display the grade selection for graphs
	 */
	public function grades(Request $request, SchoolClass $class): \Illuminate\View\View {
		$grades = Grade::whereBetween('id', [$class->first_grade, $class->last_grade])
			->where('is_professional', $class->isProfessional())
			->get();

		return view('class.graphs.grades', [
			'class' => $class,
			'grades' => $grades,
		]);
	}


	/**
	 * Display the class graphs landing page
	 */
	public function index(Request $request, SchoolClass $class, Grade $grade): \Illuminate\View\View {

		$areas = [];

		// content
		foreach ($class->grade()->areas as $doableArea) {
			$area['name'] = $doableArea->name;
			$area['id'] = $doableArea->id;
			$area['sections'] = [];

			$doableSections = [];

			$legacySectionRes = \App\Legacy\LegacyDB::select(LegacySection::INDEX . ' FROM sections WHERE ' . LegacySection::AREA_INDEX . ' = ? AND FIND_IN_SET(?, legacy_grades) ORDER BY legacy_grades ASC', [$area['id'], $grade->absolute_number]);

			if (!empty($legacySectionRes->res)) {
				$doableSections = array_merge($doableSections, $legacySectionRes->res);
			}

			$doableSections = array_keys(array_column($doableSections, null, 'id'));
			$doableSections = array_unique($doableSections);
			$doableSections = array_reverse($doableSections);

			foreach ($doableSections as $doableSectionId) {
				if (in_array($doableSectionId, [
					// Profilo - Stili cognitivi
					1,
					28,
					36,
					37,
					// Profilo - Resilienza
					3,
					// Profilo - Autostima
					4,
					29,
					41,
					// Profilo - Risolvere i problemi
					5,
					30,
					// Profilo - Stile atributivo
					6,
					// Profilo - Motivazione
					7,
					// Profilo - Temperamento
					8,
					// Profilo - La ruota delle emozioni
					27,
					// Competenze - Stare Attenti
					9,
					31,
					// Competenze - Ricordare
					10,
					32,
					// Competenze - Ascoltare
					11,
					33,
					// Competenze - Parlare
					12,
					// Competenze - Scrivere
					14,
					34,
					// Competenze - Leggere
					39,
					// Competenze - Imparare
					40,
					// Saperi - Creatività
					17,
					// Scegliere - Interessi
					24,
					45,
				])) {
					$area['sections'][] = new LegacySection($doableSectionId);
				}
			}

			if ($area['sections']) {
				$areas[] = $area;
			}
		}


		return view('class.graphs.index', [
			'class' => $class,
			'areas' => $areas
		]);
	}
}
