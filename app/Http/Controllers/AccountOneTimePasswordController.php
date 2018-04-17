<?php

namespace App\Http\Controllers;

use Google2FA;
use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountOneTimePasswordController extends Controller
{
    use HandlesAuthorization;

    public function __invoke(Account $account)
    {
        if (Gate::allows('account-access', $account)) {
            return response()->json(Google2FA::getCurrentOtp($account->secret));
        } elseif (Gate::denies('account-access', $account)) {
            return $this->deny('Unable to generate a one-time password for this account.');
        }
    }
}
