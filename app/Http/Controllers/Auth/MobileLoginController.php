<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileLoginController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (\Auth::attempt($credentials)) {
            return \Auth::user()->createToken('authpush-mobile');
        }

        return response()->json(trans('auth.failed'), 401);
    }
}
