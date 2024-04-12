<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Admin\AdminTableController;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserListController extends AdminTableController {

	/**
	 * Query configuration
	 */
	protected array $fields = [
		['label' => 'ID', 'name' => 'id'],
		['label' => 'E-mail', 'name' => 'email',],
		['label' => 'Registrato il', 'name' => 'created_at'],
	];

	/**
	 * Page configuration
	 */
	protected bool $addButton = false;

	/**
	 * Display the list of users
	 */
	public function index(Request $request): View|RedirectResponse {
		// Prepare the query
		$this->records = $this->prepareQuery();

		// Add search filter
		if ($request->search) {
			$this->records = $this->addSearchFilter($this->records, $request->search);
		}

		// Add the buttons
		$this->buttons = $this->addButtons();

		// Display the view
		return $this->view($request);
	}

	/**
	 * Prepare the query
	 */
	private function prepareQuery(): Builder {
		// Prepare the query
		return User::select('id', 'email', 'created_at');
	}

	/**
	 * Add search filters
	 */
	private function addSearchFilter(Builder $records, string $search): Builder {
		return $records->where('id', $search)
			->orWhere('email', 'like', '%' . $search . '%');
	}

	/**
	 * Add the buttons
	 */
	private function addButtons(): array {
		return [
			// [
			// 	'label' => 'Login',
			// 	'icon' => 'login',
			// 	'name' => 'login',
			// 	'color' => 'green',
			// ],
			[
				'label' => 'Modifica',
				'icon' => 'edit',
				'color' => 'blue',
				'url' => '/admin/users/edit/{id}',
			],
			[
				'label' => 'Elimina',
				'icon' => 'delete',
				'name' => 'delete',
				'color' => 'red',
				'confirmation' => true,
			],
		];
	}

	/**
	 * POST method
	 */
	public function update(Request $request): RedirectResponse {
		// Catch user redirect request
		if ($request->has('login')) {
			return $this->loginAsUser($request->login);
		}

		return Redirect::back();
	}

	/**
	 * Login as user
	 */
	private function loginAsUser(int $userId): RedirectResponse {
		$user = User::find($userId);

		if ($user) {
			Auth::login($user);

			return redirect('/profile');
		}
	}
}
