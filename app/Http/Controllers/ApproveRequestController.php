<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Events\ApprovedRequest;

class ApproveRequestController extends Controller
{
    public function store($requestHash)
    {

        // TODO - get request hash into an account

        $account = Account::first();
        broadcast(new ApprovedRequest($account));
        return response()->json('OK');
    }
}
