<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('devices', 'DevicesController');
    Route::apiResource('applications', 'ApplicationsController');
    Route::apiResource('accounts', 'AccountsController')->except('update');
});

Route::post('login', 'MobileLoginController@store');
Route::post('request/approval', 'AuthRequestController@store');
Route::post('request/{requestHash}/approve', 'ApproveAuthRequestController@store');
