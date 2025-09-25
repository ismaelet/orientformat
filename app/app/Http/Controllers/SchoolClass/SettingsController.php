<?php

namespace App\Http\Controllers\SchoolClass;

use App\Http\Controllers\Controller;
use App\Models\Schools\SchoolClass;
use Illuminate\Http\Request;

class SettingsController extends Controller {

	/**
	 * Show the student list
	 */
	public function studentIndex(Request $request, SchoolClass $class) {
		$students = $class->students->load('user')->sortBy('inverted_full_name');

		return view('class.settings.students.index', [
			'class' => $class,
			'students' => $students
		]);
	}

	/**
	 * Show the class settings
	 */
	public function showSettings(Request $request, SchoolClass $class) {
		return view('class.settings.index', [
			'class' => $class
		]);
	}

	/**
	 * Update the class settings
	 */
	public function update(Request $request, SchoolClass $class) {
		$request->validate([
			'grade' => 'required|exists:activities_grades,absolute_number',
			'letter' => 'required|string|max:10',
			'professional' => 'nullable|boolean'
		]);

		$letter = strtoupper($request->input('letter'));

		$name = $class->isMiddleSchool() ? SchoolClass::genName($request->input('grade'), $letter) : $letter;

		if (SchoolClass::where('schoolId', $class->schoolId)
			->where('id', '!=', $class->id)
			->where('name', $name)
			->where('ended', false)
			->exists()
		) {
			return redirect()->back()->withErrors(['duplicate' => 'Esiste già una classe con questo nome e di questo anno associata a questo istituto']);
		}

		$class->update([
			'grade' => $request->input('grade'),
			'letter' => $request->input('letter'),
			'name' => $name,
			'professional' => !$class->isMiddleSchool() && $request->input('professional'),
		]);

		return redirect()->back()->with('success', 'Impostazioni della classe aggiornate con successo.');
	}

	/**
	 * Delete the class
	 */
	public function destroy(Request $request, SchoolClass $class) {
		$class->delete();

		return redirect()->route('teacher.dashboard')->with('success', 'Classe eliminata con successo.');
	}
}
