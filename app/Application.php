<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;
    
    protected $guarded = [
        'id',
        'developer_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function developer()
    {
        return $this->belongsTo('App\User', 'developer_id');
    }

    public function accounts()
    {
        return $this->hasMany('App\Account');
    }
}
