<?php

namespace App\Http\Controllers;

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
}
