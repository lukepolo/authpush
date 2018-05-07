<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Device extends Model
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $hidden = ['notification_token'];

    CONST TYPES = [
        'ios',
        'android',
        'desktop'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Notification Routes
    |--------------------------------------------------------------------------
    */
    public function routeNotificationForApn()
    {
        return $this->notification_token;
    }
}
