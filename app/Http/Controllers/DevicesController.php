<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicesController extends Controller
{
    use HandlesAuthorization;

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->devices;
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

        ]);

        $device = null;

        return $device;
    }

    /**
     * @param Device $device
     * @return Device
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Device $device)
    {
        if (Gate::allows('device-access', $device)) {
            return $device;
        }
        return $this->deny('Unable to view this device.');
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param Device $device
     * @return Device
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Device $device)
    {
        if (Gate::allows('device-access', $device)) {
            $request->validate([

            ]);

            $device->update();

            return $device;
        }
        return $this->deny('Unable to modify this device.');
    }

    /**
     * @param Device $device
     * @return void
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Device $device)
    {
        if (Gate::allows('device-access', $device)) {
            $device->delete();
            return;
        }
        return $this->deny('Unable to delete this device.');
    }
}
