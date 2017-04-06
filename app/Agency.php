<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $table = 'agencys';
    protected $fillable = array(
        'wechat','user_id'
    );
    public function orders(){
        return $this->hasMany('App\Order','agency_id');
    }
}
