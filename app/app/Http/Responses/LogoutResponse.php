<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LogoutResponse as ContractsLogoutResponse;
use Illuminate\Http\RedirectResponse;

class LogoutResponse implements ContractsLogoutResponse {
	public function toResponse($request): RedirectResponse {
		return redirect()->route('login');
	}
}
