<?php

use App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function changeLanguage($locale)
    {
        if (in_array($locale, ['en', 'ar'])) {
            $user = Auth::user();

            if ($user) {
                $user->profile->locale = $locale;
                $user->profile->save();
            } else {
                session(['locale' => $locale]);
            }

            App::setLocale($locale);
        }

        return redirect()->back();
    }
}
