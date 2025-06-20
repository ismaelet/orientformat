<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller {

	/**
	 * Show the login form.
	 * 
	 * @return View
	 */
	public function index(): View {
		return view('auth.login')
			->with('locationTag', 'login')
			->with('title', 'Login');
	}

	/**
	 * Authenticate the user.
	 * 
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function auth(Request $request): RedirectResponse {
		// Validation
		$request->validate([
			'login' => 'required',
			'password' => 'required',
		]);

		if (strpos($request->login, '@') !== false) {
			$username = User::where('email', $request->login)->value('username');
		} else {
			$username = $request->login;
		}

		// Sign in
		if (!Auth::attempt(['username' => $username, 'password' => $request->password, 'active' => true])) {
			return redirect()->route('login', [
				'error' => 'login_failed',
			]);
		}

		// Redirect
		return redirect()->route('home');
	}
}
