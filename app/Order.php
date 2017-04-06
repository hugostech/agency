<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public function items(){

        return $this->belongsToMany('App\Item','order_items','order_id','item_id')->withPivot('quantity','price','status');
    }
}
