<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table='items';
    protected $fillable = array(
        'make','name','user_id','price','content'
    );
    public function orders(){
        return $this->belongsToMany('App\Order','order_items','item_id','order_id');
    }
}
