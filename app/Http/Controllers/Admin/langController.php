<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;


class langController extends Controller
{
    public function languageChanger($language)
    {
        if(array_key_exists($language, Config::get('languages'))){
            session(['appLang' => $language]);
        }
        return redirect()->back();
    }


}
