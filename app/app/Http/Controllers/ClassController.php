<?php

namespace App\Http\Controllers;

use App\Models\Class\JoinRequest;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassController extends Controller {

	/**
	 * Show the form for creating a new class
	 */
	public function create() {
		return view(
			'classes.create',
			['title' => 'Aggiungi una classe',]
		);
	}

	/**
	 * Show the form for creating a new middle school class
	 */
	public function createMiddleSchool() {
		$school = teacher()->school;

		return view(
			'classes.create.middleschool',
			['title' => 'Aggiungi una classe', 'school' => $school]
		);
	}

	/**
	 * Show the form for creating a new high school class
	 */
	public function createHighSchool() {
		$school = teacher()->school;

		return view(
			'classes.create.highschool',
			['title' => 'Aggiungi una classe', 'school' => $school]
		);
	}

	/**
	 * Show the form for joining an existing class
	 */
	public function joinShow() {
		$school = teacher()->school;
		$teacherClasses = teacher()->school_classes;
		$class = session('class');
		$classes = SchoolClass::where('schoolId', $school->id)
			->where('ended', false)
			->whereNotIn('id', $teacherClasses->pluck('id'))
			->orderBy('grade', 'asc')
			->orderBy('letter', 'asc')
			->with('referent', 'referent.user')
			->get()
			->mapWithKeys(function ($class) {
				return [$class->id => $class->name . ' (' . $class->referent?->full_name . ')'];
			});

		return view(
			'classes.join',
			['title' => 'Unisciti a una classe', 'school' => $school, 'class' => $class, 'classes' => $classes]
		);
	}

	/**
	 * Store a newly created class in storage
	 */
	public function store(Request $request): RedirectResponse {
		$request->validate([
			'letter' => 'required|string|max:255',
			'grade' => 'required|integer|in:1,2,3,4,5,6,7,8',
			'schoolId' => 'required|integer|exists:schools,id',
			'professional' => 'nullable|boolean',
		]);

		$letter = strtoupper($request->input('letter'));
		$referentId = teacher()->id;
		$code = bin2hex(random_bytes(5));
		$startingYear = (date('n') < 9) ? date('Y', strtotime('-1 year')) : date('Y');

		while (SchoolClass::where('code', $code)->exists()) {
			$code = bin2hex(random_bytes(5));
		}

		if (SchoolClass::where('schoolId', $request->input('schoolId'))
			->where('grade', $request->input('grade'))
			->where('letter', $letter)
			->where('ended', false)
			->exists()
		) {
			$name = $request->input('grade') > Grade::lastMiddleschool() ?  $letter : $request->input('grade') . $letter;

			return back()->withErrors(['duplicate' => "Esiste già una classe {$name} in questo istituto."])->withInput();
		}

		$class = SchoolClass::create([
			'schoolId' => $request->input('schoolId'),
			'referentId' => $referentId,
			'grade' => $request->input('grade'),
			'startingGrade' => $request->input('grade'),
			'letter' => $letter,
			'code' => $code,
			'startingYear' => $startingYear,
			'year' => $startingYear,
			'professional' => $request->input('professional', false),
		]);

		teacher()->school_classes()->attach($class->id);

		return redirect()->route('teacher.dashboard')->with('success', 'Classe aggiunta con successo.');
	}

	/**
	 * Store a newly created class in storage
	 */
	public function joinStore(Request $request): RedirectResponse {
		$request->validate([
			'class_id' => 'required|integer|exists:school_classes,id',
		]);

		$class = SchoolClass::findOrFail($request->input('class_id'));

		if ($class->school != teacher()->school) {
			return back()->withErrors(['class_id' => 'La classe selezionata non appartiene al tuo istituto.'])->withInput();
		}

		if (!JoinRequest::where('class_id', $class->id)
			->where('requesting_teacher_id', teacher()->id)
			->exists()) {

			JoinRequest::create([
				'class_id' => $class->id,
				'referent_id' => $class->referent->id,
				'requesting_teacher_id' => teacher()->id,
			]);
		}

		return redirect()->route('classes.join.show')->with('class', $class);
	}

	/**
	 * Accept a join request
	 */
	public function joinAccept(Request $request, JoinRequest $joinRequest): RedirectResponse {
		if ($joinRequest->referent_id != teacher()->id) {
			return back()->withErrors(['join_request_id' => 'Non sei autorizzato ad accettare questa richiesta.'])->withInput();
		}

		teacher()->school_classes()->attach($joinRequest->class_id);

		$joinRequest->delete();

		return redirect()->route('teacher.dashboard')->with('success', 'Richiesta accettata con successo.');
	}

	/**
	 * Reject a join request
	 */
	public function joinReject(Request $request, JoinRequest $joinRequest): RedirectResponse {
		if ($joinRequest->referent_id != teacher()->id) {
			return back()->withErrors(['join_request_id' => 'Non sei autorizzato a rifiutare questa richiesta.'])->withInput();
		}

		$joinRequest->delete();

		return redirect()->route('teacher.dashboard')->with('success', 'Richiesta rifiutata con successo.');
	}
}
