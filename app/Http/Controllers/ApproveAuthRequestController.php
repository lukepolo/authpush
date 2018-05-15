<?php

namespace App\Http\Controllers;

use App\Models\AuthRequest;
use App\Events\ApprovedRequest;

class ApproveAuthRequestController extends Controller
{
    /**
     * @param $requestHash
     */
    public function store($requestHash)
    {
        $authRequest= AuthRequest::with('account')->where('id', $requestHash);
        broadcast(new ApprovedRequest($authRequest->account));
    }
}
