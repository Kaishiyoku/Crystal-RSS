<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change(Request $request)
    {
        $locale = $request->get('locale');

        if (in_array($locale, config('app.available_locales'))) {
            Session::put('locale', $locale);
        } else {
            flash()->error(__('language.invalid_locale'));
        }

        return back();
    }
}
