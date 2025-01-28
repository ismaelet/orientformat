<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {

	/**
	 * Render the login page
	 */
	public function index() {
		return view('auth.login')
			->with('locationTag', 'login')
			->with('title', 'Login');
	}

	/**
	 * Authenticate the user
	 */
	public function auth(Request $request): RedirectResponse {

		// validation
		$request->validate([
			'login' => 'required',
			'password' => 'required',
		]);

		if (strpos($request->login, '@') !== false) {
			$username = User::where('email', $request->login)->value('username');
		} else {
			$username = $request->login;
		}

		// sign in the user
		if (!Auth::attempt(['username' => $username, 'password' => $request->password, 'active' => true])) {
			return redirect()->route('login', [
				'error' => 'login_failed',
			]);
		}

		// redirect
		return redirect()->route('home');
	}
}
