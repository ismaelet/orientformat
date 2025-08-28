<?php

namespace App\View\Components\Student;

use App\Helpers\SectionResultHelper;
use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Legacy\Activity\Result\Handler\StudentSectionResult;
use Legacy\UserSystem\Student as LegacyStudent;

class Poi extends Component {

	public SchoolClass $class;

	public $beginnerChoice;

	public $endChoice;

	public $results;

	public $advices;

	public $userType = 'student';

	public $description = [
		'student' => 'Il <strong>POI</strong> ti fornisce un quadro complessivo e sintetico delle tue autovalutazioni relative alle competenze personali e alle competenze di base trasversali. Il quadro viene integrato e aggiornato in base sezioni che hai completato. Il profilo che viene così definendosi sulla base delle tue autovalutazioni è condiviso anche dai tuoi insegnanti. Se vuoi, puoi inserire il tuo POI
nell’e-portfolio.',
		'teacher' => 'Il <strong>POI</strong> fornisce la sintesi delle autovalutazioni dello studente sia per le competenze non (strettamente) cognitive sia per le competenze di base trasversali. Si rende in tal modo evidente il confronto tra le valutazioni dei docenti e la visione che ha di sé lo studente.'
	];

	public array $structure;

	public string $returnUrl;

	/**
	 * Create a new component instance.
	 */
	public function __construct(public Student $student) {
		$this->class = $student->school_class;
		$gradeNumber = $this->class->grade()->absolute_number;

		$this->userType = is_teacher() ? 'teacher' : 'student';

		$legacyStudent = new LegacyStudent($student->id);
		$profile = $legacyStudent->profile;
		$this->beginnerChoice = $profile->dynamicChoice([1, 2, 4, 5]);
		$this->endChoice = $profile->dynamicChoice([3, 6]);

		$stiliId = $gradeNumber < 3 ? 28 : ($gradeNumber == 3 ? 1 : 36);
		$autostimaId = $gradeNumber < 3 ? 29 : 4;

		$this->returnUrl = $this->userType == 'student' ? route('activities.grades.show', ['grade' => $this->class->grade()]) : route('class.students.results.index', ['class' => $this->class]);

		$this->structure = [
			// [
			// 	'name' => "Scelta indicata nei questionari",
			// 	'description' => 'Qui puoi trovare la scelta che è stata effettuata nei questionari iniziale e finale, e il grado di sicurezza.',
			// 	'custom' => true,
			// ],
			[
				'name' => "Area Motivazionale",
				'subtitle' => '(Consapevolezza ed espressione culturali)',
				'description' => 'Qui puoi trovare i risultati relativi alle fonti di motivazione principali.',
				'sections' => [7, 24],
			],
			[
				'name' => "Area Personale",
				'subtitle' => '(Competenze sociali, civiche e di cittadinanza)',
				'description' => 'Qui puoi trovare le autovalutazioni relative alle competenze non (direttamente) cognitive.',
				'sections' => [27, $stiliId, 3, $autostimaId, 6, 8],
			],
			[
				'name' => "Area Competenza Alfabetica Funzionale",
				'subtitle' => '(Comunicazione nella lingua italiana)',
				'description' => 'Qui puoi trovare i risultati conseguiti nelle sezioni relative alle competenze alfabetiche funzionali.',
				'sections' => [11, 12, 39, 14],
			],
			[
				'name' => "Area Imparare a imparare",
				'subtitle' => '(Competenze di auto-osservazione e auto-regolazione)',
				'description' => 'Qui puoi trovare i risultati conseguiti nelle sezioni relative alle abilità e strumenti inerenti alle competenze di apprendimento.',
				'sections' => [9, 10, 5, 40],
			],
			// [
			// 	'name' => "Area Competenza Imprenditoriale",
			// 	'subtitle' => '(Spirito di iniziativa e imprenditorialità)',
			// 	'description' => 'Qui puoi trovare i risultati relativi ai tipi di pensiero e alle capacità autoimprenditoriali.',
			// 	'custom' => true,
			// ],
		];

		$this->results = [
			'creatività' => (new StudentSectionResult(17, $student->id))->detailedResult,
		];


		// fetch advices
		$advices = [];
		$advicesRes = \App\Legacy\LegacyDB::select('id, advice FROM advices_list ORDER BY id ASC');

		while ($advice = $advicesRes->fetch_assoc()) {
			$advices[$advice['id']] = $advice['advice'];
		}

		$this->advices = $advices;
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string {
		return view('components.student.poi');
	}
}
