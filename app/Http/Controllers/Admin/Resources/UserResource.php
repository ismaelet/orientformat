<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Http\Controllers\Admin\ResourceController;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserResource extends ResourceController {

	/**
	 * ~ Action Configuration: Index
	 */
	protected $columns = [
		['label' => 'ID', 'name' => 'id'],
		['label' => 'Nome', 'name' => 'firstName'],
		['label' => 'Cognome', 'name' => 'lastName'],
		['label' => 'E-mail', 'name' => 'email',],
		['label' => 'Registrazione', 'name' => 'created_at', 'type' => 'date'],
	];

	/**
	 * ~ Action Configuration: Edit
	 */
	protected $recordClass = User::class;
	protected $titleField = 'username';

	/**
	 * * Action: Index
	 */
	public function index(Request $request): View {
		// Prepare the query
		$this->query = User::query();

		// Add search filter
		if ($request->search) {
			$this->query = $this->query->where('users.id', $request->search)
				->orWhere('firstName', 'like', '%' . $request->search . '%')
				->orWhere('lastName', 'like', '%' . $request->search . '%')
				->orWhere('email', 'like', '%' . $request->search . '%');
		}

		// Add the buttons
		$this->buttons = [
			['type' => 'delete'],
			[
				'label' => 'Login',
				'icon' => 'login',
				'color' => 'green',
				'route' => 'admin.users.login',
			],
		];

		return parent::index($request);
	}

	/**
	 * * Action: Edit
	 */
	public function edit(int $userId): View {
		User::findOrFail($userId);

		return parent::edit($userId);
	}

	public function destroy(int $userId): RedirectResponse {
		$user = User::findOrFail($userId);

		$user->delete();

		return redirect()->route('admin.users.index');
	}

	/**
	 * * Action: Update
	 */
	public function update(int $userId, Request $request): RedirectResponse {
		// Find the record
		$user = User::findOrFail($userId);

		// Validate the request
		$request->validate([
			'firstName' => ['string', 'max:255'],
			'lastName' => ['string', 'max:255'],
			'email' => ['required', 'email'],
		]);

		$user->update($request->only(['email', 'firstName', 'lastName']));

		return parent::update($userId, $request);
	}

	/**
	 * * Custom Action: Login
	 */
	public function login(Request $request): RedirectResponse {
		$user = User::findOrFail($request->id);

		auth()->login($user);

		return redirect()->route('home');
	}
}
