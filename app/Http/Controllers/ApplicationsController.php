<?php

namespace App\Http\Controllers;

use App\Rules\ValidDomain;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationsController extends Controller
{
    use HandlesAuthorization;

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->applications;
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return Application
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
     * @param  \App\Models\Application $application
     * @return Application
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Application $application)
    {
        if (Gate::allows('develops-application', $application)) {
            return $application;
        }
        return $this->deny('Unable to view this application.');
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Application $application
     * @return Application
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
        }
        return $this->deny('Unable to modify this application.');
    }

    /**
     * @param  \App\Models\Application $application
     * @return void
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Application $application)
    {
        if (Gate::allows('develops-application', $application)) {
            $application->delete();
            return;
        }
        return $this->deny('Unable to delete this application.');
    }
}
