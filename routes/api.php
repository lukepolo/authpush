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
Route::post('/otp/request', function (\Illuminate\Http\Request $request) {
    $user = \App\User::where('email', $request->email)->first();
    $user->notify(new \App\Notifications\RequestApproval());
    return response()->json('OK');
});
