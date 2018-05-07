<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('accounts', 'AccountsController')->except('update');
    Route::get('accounts/{account}/otp', 'AccountOneTimePasswordController');

    Route::apiResource('applications', 'ApplicationsController');
});

Route::post('devices', 'DevicesController@store');
Route::post('request/approval', 'AuthRequestController@store');
Route::post('request/{requestHash}/approve', 'ApproveAuthRequestController@store');
