<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use System\Classes\ActiveUser;

class LogoutController extends Controller {

	/**
	 * Render the logout page
	 */
	public function index() {
		return view('auth.logout')
			->with('locationTag', 'logout')
			->with('title', 'Logout');
	}

	/**
	 * Logout the user
	 */
	public function logout() {
		auth()->logout();
		session()->flush();

		return redirect()->route('login');
	}
}
