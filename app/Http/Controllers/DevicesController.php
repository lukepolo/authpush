<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Rules\ValidDeviceType;
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
            'name' => 'required',
            'device_unique_id' => ['required'],
            'type' => ['required', new ValidDeviceType],
        ]);

        $device = Device::create([
            'user_id' => auth()->user()->id,
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'device_unique_id' => $request->get('device_unique_id'),
            'notification_token' => $request->get('notification_token'),
        ]);

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
                'name' => 'required',
            ]);

            $device->update([
                'name' => $request->get('name'),
                'notification_token' => $request->get('notification_token', $device->notification_token),
            ]);

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
