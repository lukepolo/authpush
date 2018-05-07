<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Application;
use App\Models\Device;
use App\Notifications\RequestApproval;
use Illuminate\Http\Request;

class RequestApprovalController extends Controller
{
    public function store(Request $request)
    {
        $account = Account::with(['user', 'application'])->where('label', $request->email)
            ->where('application_id', $request->token)
            ->first();

        /** @var Device $device */
        foreach ($account->user->devices as $device) {
            $device->notify(new RequestApproval($account));
        };

        return response()->json('OK');
    }
}
