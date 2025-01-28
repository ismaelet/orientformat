<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminSection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ResourceController extends Controller {

	/**
	 * ~ Action Configuration: Index
	 */
	protected $query;
	protected $orderItemBy = ['id' => 'desc'];
	protected $orderDirection = 'desc';
	protected $columns = [];
	protected $buttons = [];
	protected $pageSize = 50;
	protected $searchBar = true;

	/**
	 * ~ Action Configuration: Edit
	 */
	protected $recordClass;
	protected $titleField;

	/**
	 * * Action: Index
	 *
	 * Display the index view with the configured settings.
	 *
	 * @param Request $request The HTTP request object.
	 * @return View The index view.
	 */
	protected function index(Request $request): View {
		// Display the view
		return view('components.dashboard.table.index')->with([
			'title' => $this->sectionTitle(),
			'columns' => $this->columns(),
			'records' => $this->records($request),
			'recordCount' => $this->recordCount(),
			'mainOrderBy' => $this->mainOrderBy(),
			'orderDirection' => $this->orderDirection($request),
			'buttons' => $this->buttons,
			'searchBar' => $this->searchBar,
		]);
	}

	/**
	 * * Action: Edit
	 * 
	 * View the edit form for a specific record.
	 *
	 * @param int $id The ID of the record to edit.
	 * @return View The edit view.
	 */
	protected function edit(int $recordId): View {
		$record = $this->recordClass::find($recordId);

		return view(Route::currentRouteName())
			->with([
				'title' => $this->formTitle($record),
				'record' => $record,
				'type' => $record ? 'edit' : 'add',
			]);
	}

	/**
	 * * Action: Update
	 *
	 * @param Request $request The ID of the record to show.
	 * @return RedirectResponse The redirect response.
	 */
	protected function update(int $recordId, Request $request): RedirectResponse {
		$routeName = explode_last('.', Route::currentRouteName())[0] . '.index';

		$routeParameters = json_decode($request->route()->index_parameters, true);

		return redirect()->route($routeName, $routeParameters);
	}

	/**
	 * ~ General Helper: Admin Section
	 * 
	 * @return AdminSection The admin section associated with the resource route.
	 */
	private function section(): AdminSection {
		return AdminSection::findBySlug(Route::currentRouteName());
	}

	/**
	 * ~ General Helper: Section Title
	 *
	 * @return string The title of the section.
	 */
	private function sectionTitle(): string {
		return $this->section()->name;
	}

	/**
	 * ~ Index Helper: Records
	 *
	 * @param Request $request The request object.
	 * @return Collection The collection of records.
	 */
	private function records(Request $request): Collection {
		$records = clone $this->query;
		$currentPage = $request->page ?: 1;
		$orderItemBy = $this->orderBy($request);

		foreach ($orderItemBy as $field => $direction) {
			$records->orderBy($field, $direction);
		}

		return $records
			->skip(($currentPage - 1) * $this->pageSize)
			->take($this->pageSize)
			->get();
	}

	/**
	 * ~ Index Helper: Record Count
	 *
	 * @return int The number of records.
	 */
	private function recordCount(): int {
		return $this->query->count();
	}

	/**
	 * ~ Index Helper: Order By
	 * 
	 * Get the order field.
	 *
	 * @param Request $request The request object.
	 * @return array The order field.
	 */
	private function orderBy(Request $request): array {
		if ($request->order_by) {
			return $this->orderItemBy = [$request->order_by => $this->orderDirection($request)];
		}

		return $this->orderItemBy;
	}

	/**
	 * ~ Index Helper: Order Direction
	 *
	 * @param Request $request The request object.
	 * @return string The order direction.
	 */
	private function orderDirection(Request $request): string {
		if ($request->order_direction) {
			return $request->order_direction;
		}

		return reset($this->orderItemBy);
	}

	/**
	 * ~ Index Helper: Main Order By
	 * 
	 * @return string The first key of the $orderItemBy array.
	 */
	private function mainOrderBy(): string {
		return array_key_first($this->orderItemBy);
	}

	/**
	 * ~ Index Helper: Columns
	 *
	 * @return array Generate the table columns array.
	 */
	private function columns(): array {
		if (!empty($this->buttons)) {
			$this->columns[] = [];
		}

		return $this->columns;
	}

	/**
	 * ~ Edit Helper: Form Title
	 *
	 * @return string The form title.
	 */
	private function formTitle(Object $record): string {
		return 'Modifica: ' . $record->{$this->titleField};
	}
}
