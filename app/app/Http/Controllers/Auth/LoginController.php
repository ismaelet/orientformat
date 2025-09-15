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
	 * Show the login form
	 */
	public function index(Request $request) {
		$studentType = 'student';
		$teacherType = 'teacher';
		$loginType = $request->query('login-type', $studentType);
		$loginType = in_array($loginType, [$studentType, $teacherType]) ? $loginType : $studentType;
		$register = $request->query('register', false);

		return view('auth.login')
			->with([
				'location' => 'login',
				'title' => 'Login',
				'loginType' => $loginType,
				'studentType' => $studentType,
				'teacherType' => $teacherType,
				'register' => $register,
			]);
	}

	/**
	 * Authenticate the user
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
			return redirect()->back()
				->withInput($request->only('login'))
				->withErrors(['login' => 'Invalid credentials or account not active.']);
		}

		// Redirect
		return redirect()->route('home');
	}
}
