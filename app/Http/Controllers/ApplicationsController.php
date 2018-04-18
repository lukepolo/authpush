<?php

namespace App\Http\Controllers;

use App\Application;
use App\Rules\ValidDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationsController extends Controller
{
    use HandlesAuthorization;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->applications;
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
            'name' => 'required|string',
            'domain' => ['required', new ValidDomain],
        ]);

        $application = new Application([
            'name' => $request->name,
            'domain' => $request->domain,
        ]);

        auth()->user()->applications()->save($application);

        return $application;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        if (Gate::allows('develops-application', $application)) {
            return $application;
        } elseif (Gate::denies('develops-application', $application)) {
            return $this->deny('Unable to view this application.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        if (Gate::allows('develops-application', $application)) {
            $request->validate([
                'name' => 'required|string',
                'domain' => 'required|domain',
            ]);

            $application->name = $request->name;
            $application->domain = $request->domain;

            $application->update();

            return $application;
        } elseif (Gate::denies('develops-application', $application)) {
            return $this->deny('Unable to modify this application.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        if (Gate::allows('develops-application', $application)) {
            $application->delete();
            return;
        } elseif (Gate::denies('develops-application', $application)) {
            return $this->deny('Unable to modify this account.');
        }
    }
}
