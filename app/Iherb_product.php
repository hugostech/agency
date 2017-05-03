<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iherb_product extends Model
{
    protected $connection = 'iherbs';
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    public function description(){
        return $this->hasOne('App\Ihreb_product_description','product_id');
    }
}

