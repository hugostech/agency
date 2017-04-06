<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        $backorder = array();
        foreach ($items as $item){
            $quantity = DB::table('order_items')->select(DB::raw('SUM(quantity) as quantity'))->where('status','p')->where('item_id',$item->id)->get();
            $num = $quantity->pluck('quantity')->all()[0];
            if($num>0){
                $backorder[$item->make.$item->name] = $num;

            }

        }
        return view('home',compact('backorder'));
    }
}
