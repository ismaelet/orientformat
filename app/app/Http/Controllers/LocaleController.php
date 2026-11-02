<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Switch the application locale
     */
    public function switchLocale(string $locale): RedirectResponse
    {
        if (array_key_exists($locale, config('app.locales'))) {
            Session::put('locale', $locale);
            setcookie('locale', $locale, time() + (86400 * 30), '/'.env('APP_SUBDOMAIN'));
        }

        return redirect()->back();
    }
}
