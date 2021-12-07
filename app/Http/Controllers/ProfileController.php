<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());

        return view('pages.profile', $user);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['email','required'],
            'name'  => ['required'],
        ], [
            'email.email'       => 'Email tidak valid',
            'email.required'    => 'Email harus terisi',
        ])
    }

}
