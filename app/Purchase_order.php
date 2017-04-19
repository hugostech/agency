<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_order extends Model
{
    protected $table='purchase_orders';
    protected $fillable = array(
        'user_id','supplier','supplier_order','status'
    );
    public function items(){
        return $this->belongsToMany('App\Item','purchase_order_items','purchase_order_id','item_id')
            ->withPivot(['quantity','price','status']);
    }
}
