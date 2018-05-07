<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (\Auth::attempt($credentials)) {
            return \Auth::user()->createToken('authpush-mobile');
        }

        return response()->json('NOPE', 401);
    }
}
