<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Http\Controllers\Admin\ResourceController;
use App\Models\User\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentResource extends ResourceController {

	/**
	 * ~ Action Configuration: Index
	 */
	protected $columns = [
		['label' => 'ID', 'name' => 'id'],
		['label' => 'Username', 'name' => 'username'],
		['label' => 'Nome Completo', 'name' => 'full_name'],
		['label' => 'Classe', 'name' => 'school_class'],
		['label' => 'Istituto', 'name' => 'school_name'],
		['label' => 'Referente', 'name' => 'referent_name'],
		['label' => 'Registrazione', 'name' => 'created_at', 'type' => 'date'],
	];

	/**
	 * ~ Action Configuration: Edit
	 */
	protected $recordClass = Student::class;
	protected $titleField = 'username';

	/**
	 * * Action: Index
	 */
	public function index(Request $request): View {
		// Prepare the query
		$this->query = Student::join('users', 'users.id', '=', 'students.userId')
			->leftJoin('school_classes', 'school_classes.id', '=', 'students.schoolClassId')
			->leftJoin('schools', 'schools.id', '=', 'school_classes.schoolId')
			->leftJoin('users as referents', 'referents.id', '=', 'school_classes.referentId')
			->select('students.*', 'users.username', 'school_classes.grade as school_class_grade', 'school_classes.letter as school_class_section', 'schools.name as school_name')
			->selectRaw('CONCAT(referents.first_name, " ", referents.last_name) as referent_name, CONCAT(users.first_name, " ", users.last_name) as full_name, CONCAT(school_classes.grade, school_classes.letter) as school_class');

		// Add search filter
		if ($request->search) {
			$this->query = $this->query->where('users.id', $request->search)
				->orWhere('users.first_name', 'like', '%' . $request->search . '%')
				->orWhere('users.last_name', 'like', '%' . $request->search . '%')
				->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ['%' . $request->search . '%'])
				->orWhereRaw("CONCAT(users.last_name, ' ', users.first_name) LIKE ?", ['%' . $request->search . '%'])
				->orWhere('referents.first_name', 'like', '%' . $request->search . '%')
				->orWhere('referents.last_name', 'like', '%' . $request->search . '%')
				->orWhere('schools.name', 'like', '%' . $request->search . '%');
		}

		// Add the buttons
		$this->buttons = [
			['type' => 'edit'],
			['type' => 'delete'],
		];

		return parent::index($request);
	}

	/**
	 * * Action: Edit
	 */
	public function edit(int $userId): View {
		Student::findOrFail($userId);

		return parent::edit($userId);
	}

	/**
	 * * Action: Update
	 */
	public function update(int $userId, Request $request): RedirectResponse {
		// Find the record
		$user = Student::findOrFail($userId);

		// Validate the request
		$request->validate([
			'schoolClassId' => ['required', 'exists:school_classes,id'],
		]);

		$user->update($request->only(['schoolClassId']));

		return parent::update($userId, $request);
	}

	/**
	 * * Action: Destroy
	 */
	public function destroy(Student $student): RedirectResponse {
		$student->delete();

		return redirect()->back();
	}
}
