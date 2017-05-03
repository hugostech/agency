<?php namespace bb;
use App\Iherb_product;
use App\Iherb_brand;
use App\Item;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 3/05/17
 * Time: 12:05 AM
 */
trait iherb{
    public function importBrand(){
        Iherb_brand::chunk(100, function($brands){
           foreach ($brands as $brand){
               $products = $brand->products;
               if(count($products) < 1){
                   continue;
               }
               foreach ($products as $product){
                   if (is_null($product->description->name)) continue;
                   $item = new Item();
                   $item->user_id = Auth::user()->id;
                   $item->name = $product->description->name;
                   $item->make = $brand->name;
                   $item->content = $product->description->description;
                   $item->image = $product->image;
                   $item->save();
               }
           }
        });

    }
    public function test(){
        dd('as');
    }
}