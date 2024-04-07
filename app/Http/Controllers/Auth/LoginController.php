<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
	public function auth(Request $request) {
		// validation
		$this->validate($request, [
			'email' => ['required', 'email'],
			'password' => 'required',
		]);

		// sign in the user
		if (!Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
			return back()->with('error', 'Dati di accesso errati');
		}

		// redirect
		return redirect()->route('user-dashboard');
	}
}
