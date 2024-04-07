<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\UserReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller {

	/**
	 * Render the reset page
	 */
	public function index() {

		$userId = $_GET['user_id'] ?? null;
		$securityCode = $_GET['security_code'] ?? null;

		if (!$userId || !$securityCode) {
			return redirect()->route('auth.recover')->with('status', 'Errore durante il reset della password');
		}

		return view('auth.reset')
			->with([
				'title' => 'Reset accesso',
				'error' => !UserReset::where('user_id', $userId)->where('security_code', Hash::make($securityCode))->count(),
				'userId' => $userId,
				'securityCode' => $securityCode,
			]);
	}

	/**
	 * Process the request
	 */
	public function update(Request $request) {

		// Validation
		$this->validate($request, [
			'password' => ['required', 'confirmed'],
		]);

		// Process the request
		$user = User::find($request->user_id);
		$securityCode = $request->security_code;

		if ($user) {
			$userReset = UserReset::where('user_id', $user->id)->where('security_code', Hash::make($securityCode))->first();

			if ($userReset) {
				$user->update([
					'password' => Hash::make($_POST['password']),
				]);

				$userReset->delete();

				return back()->with('submitted', true);
			}

			return back()->with('error', 'Il link di rest non è valido o è scaduto');
		}

		return back()->with('error', 'Errore durante il reset della password');
	}
}
