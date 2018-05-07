<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Events\ApprovedRequest;

class ApproveAuthRequestController extends Controller
{
    /**
     * @param $requestHash
     */
    public function store($requestHash)
    {

        // TODO - get request hash into an account

        $account = Account::first();
        broadcast(new ApprovedRequest($account));
    }
}
