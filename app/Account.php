<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use Encryptable, SoftDeletes;
    
    protected $fillable = [
        'label',
        'secret',
        'secret_type',
        'application_id'
    ];

    protected $dates = ['deleted_at'];

    protected $encryptable = ['secret'];
    
    protected $hidden = ['secret'];
}
