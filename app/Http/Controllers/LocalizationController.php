<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * Switch the application locale.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($locale)
    {
        // List of supported locales
        $availableLocales = ['en', 'ar','he'];

        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
            // dd('hello');
            App::setlocale($locale);
        }

        return back();
    }
}