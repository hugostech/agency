<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ihreb_product_description extends Model
{
    protected $connection = 'iherbs';
    protected $table = 'product_description';
    protected $primaryKey = 'product_description_id';
}
