<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('accounts', 'AccountsController')->except('update');
    Route::get('accounts/{account}/otp', 'AccountOneTimePasswordController');

    Route::apiResource('applications', 'ApplicationsController');

    Route::get('accounts/{account}/otp/approve', function ($account) {
        broadcast(new \App\Events\Approved(
            \App\Application::findOrFail($account),
            \Auth::user()
        ));
    });
});

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
Route::post('/otp/request', function (\Illuminate\Http\Request $request) {
    $account = \App\Account::with(['user', 'application'])->where('label', $request->email)
        ->where('application_id', $request->token)
        ->first();

    $account->user->notify(new \App\Notifications\RequestApproval($account));
    return response()->json('OK');
});


Route::post('token', function (\Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');

    if (\Auth::attempt($credentials)) {
        return \Auth::user()->createToken('authpush-mobile');
    }

    return response()->json('NOPE', 401);
});
