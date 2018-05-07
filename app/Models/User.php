<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'apn_token',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'developer_id');
    }

    public function devices()
    {
        return $this->belongsTo(Device::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Notification Routes
    |--------------------------------------------------------------------------
    */
    public function routeNotificationForApn()
    {
        return $this->apn_token;
    }
}
