<?php

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('accounts', 'AccountsController')->except('update');
    Route::get('accounts/{account}/otp', 'AccountOneTimePasswordController');

    Route::apiResource('applications', 'ApplicationsController');
});

Route::post('token', 'TokenController');
Route::post('/request/approval', 'RequestApprovalController');
Route::post('/request/{requestHash}/approve', 'ApproveRequestController');
