<?php

namespace App\View\Components\Student;

use App\Models\Schools\Grade;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Autovalutazioni extends Component {

	public string $description;

	public Collection $grades;

	public string $userType;

	public string $returnUrl;

	/**
	 * Create a new component instance.
	 */
	public function __construct(public Student $student) {
		$class = $student->school_class;
		$startGrade = $class->first_grade;
		$currentGrade = $class->grade()->absolute_number;
		$this->userType = is_teacher() ? 'teacher' : 'student';

		$this->grades = Grade::whereBetween('absolute_number', [$startGrade, $currentGrade])
			->where('is_professional', $class->isProfessional())
			->orderByDesc('absolute_number')
			->with('areas', 'sections', 'sections.evaluation_test')
			->get();

		$this->description = $this->userType == 'student' ? 'In tutte le sezioni ti si richiede un’autovalutazione sulla base dei descrittori di competenza. In diverse
		sezioni ti viene
		richiesto di metterti alla prova per verificare la fondatezza dei dati da te forniti. Ad ogni prova viene attribuito un punteggio, che funziona da stimolo a rivedere eventualmente la tua autovalutazione, ma non influisce sul punteggio della sezione
		che trovi nel Profilo Orientativo Individualizzato (POI). Puoi decidere tu quali autovalutazioni vuoi inserire
		nell’e-portfolio.' : 'Qui puoi trovare, suddivise per anno, tutte le autovalutazioni che hai concluso, con il relativo punteggio. Cliccando sul link, puoi vedere il grafico corrispondente e valutare se i risultati concordano con la valutazione dei tuoi insegnanti e che cosa nel frattempo è eventualmente cambiato. Puoi anche trasferire le autovalutazioni che ritieni più importanti nell’e-portfolio <a class="text-link" href="https://unica.istruzione.gov.it/portale/it/orientamento/il-tuo-percorso/e-portfolio">https://unica.istruzione.gov.it/portale/it/orientamento/il-tuo-percorso/e-portfolio</a>.';

		$this->returnUrl = $this->userType == 'student' ? route('activities.grades.show', ['grade' => $class->grade()]) : route('class.students.results.index', ['class' => $class]);
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string {
		return view('components.student.autovalutazioni');
	}
}
