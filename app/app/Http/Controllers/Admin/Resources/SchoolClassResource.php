<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Http\Controllers\Admin\ResourceController;
use App\Models\Schools\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolClassResource extends ResourceController {

	/**
	 * ~ Action Configuration: Index
	 */
	protected $columns = [
		['label' => 'ID', 'name' => 'id'],
		['label' => 'Anno', 'name' => 'grade'],
		['label' => 'Sezione', 'name' => 'letter'],
		['label' => 'Istituto', 'name' => 'school_name'],
		['label' => 'Referente', 'name' => 'referent_name'],
		['label' => 'Codice', 'name' => 'code'],
	];

	/**
	 * ~ Action Configuration: Edit
	 */
	protected $recordClass = SchoolClass::class;
	protected $titleField = 'username';

	/**
	 * * Action: Index
	 */
	public function index(Request $request): View {
		// Prepare the query
		$this->query = SchoolClass::join('schools', 'schools.id', '=', 'school_classes.schoolId')
			->leftJoin('users as referents', 'referents.id', '=', 'school_classes.referentId')
			->select('school_classes.*', 'schools.name as school_name')
			->selectRaw('CONCAT(referents.first_name, " ", referents.last_name) as referent_name');

		// Add search filter
		if ($request->search) {
			$this->query = $this->query->where('school_classes.id', $request->search)
				->orWhere('grade', $request->search)
				->orWhere('letter', $request->search)
				->orWhere('code', $request->search)
				->orWhere('referents.first_name', 'like', '%' . $request->search . '%')
				->orWhere('referents.last_name', 'like', '%' . $request->search . '%')
				->orWhere('schools.name', 'like', '%' . $request->search . '%');
		}

		// Add the buttons
		$this->buttons = [
			['type' => 'delete'],
		];

		return parent::index($request);
	}

	/**
	 * * Action: Destroy
	 */
	public function destroy(SchoolClass $schoolClass, Request $request): RedirectResponse {
		$schoolClass->delete();

		return redirect()->back();
	}
}
