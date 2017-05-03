<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Iherb_brand extends Model
{
    protected $connection = 'iherbs';
    protected $table = 'manufacturer';
    protected $primaryKey = 'manufacturer_id';
    public function products(){
        return $this->hasMany('App\Iherb_product','manufacturer_id');
    }
}
