<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DarkSwitcherController extends Controller
{
    public function switcher()
    {
        session([
            'dark_mode' => session()->has('dark_mode') ? !session()->get('dark_mode') : true
        ]);

        return back();
    }
}
