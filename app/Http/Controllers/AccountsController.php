<?php

namespace App\Http\Controllers;

use App\Account;
use App\Application;
use App\Rules\ValidDomain;
use Illuminate\Http\Request;
use App\Rules\Valid2FASecret;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountsController extends Controller
{
    use HandlesAuthorization;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->accounts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        if (Gate::allows('account-access', $account)) {
            return $account;
        } elseif (Gate::denies('account-access', $account)) {
            return $this->deny('Unable to view this account.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        if (Gate::allows('account-access', $account)) {
            $account->delete();
            return;
        } elseif (Gate::denies('account-access', $account)) {
            return $this->deny('Unable to modify this account.');
        }
    }
}
