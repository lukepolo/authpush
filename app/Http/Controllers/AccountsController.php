<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Rules\ValidDomain;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Rules\Valid2FASecret;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountsController extends Controller
{
    use HandlesAuthorization;

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->accounts;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return Account
     */
    public function store(Request $request)
    {
        $request->validate([
            'application' => ['required', 'exists:applications,domain', new ValidDomain],
            'secret' => ['required', new Valid2FASecret],
        ]);

        $application = Application::where('domain', $request->application)->firstOrFail();

        $account = new Account([
            'label' => $request->label,
            'secret' => $request->secret,
            'application_id' => $application->id,
            'secret_type' => 'totp', // TODO: Hardcoded until multiple secret types are supported.
        ]);

        auth()->user()->accounts()->save($account);

        return $account;
    }

    /**
     * @param  \App\Models\Account $account
     * @return Account
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Account $account)
    {
        if (Gate::allows('account-access', $account)) {
            return $account;
        }
        return $this->deny('Unable to view this account.');
    }

    /**
     * @param  \App\Models\Account $account
     * @return void
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Account $account)
    {
        if (Gate::allows('account-access', $account)) {
            $account->delete();
            return;
        } elseif (Gate::denies('account-access', $account)) {
            return $this->deny('Unable to delete this account.');
        }
    }
}
