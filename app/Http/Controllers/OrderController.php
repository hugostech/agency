<?php

namespace App\Http\Controllers;

use App\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'id'=>'required',

        ]);
//        dd($request->all());
        DB::beginTransaction();
        $total = 0;
        $order = new Order();
        $order->agency_id = $request->input('agency_id');
        $order->total = $total;

        $order->save();
        var_dump($order->id);
        $ids = $request->input('id');
        $quantitys = $request->input('quantity');
        $prices = $request->input('price');
        $item_name = $request->input('item_name');
        foreach ($ids as $key=>$id){


            $order->items()->attach($id,['quantity'=>$quantitys[$key],'price'=>$prices[$key],'status'=>'p','item_name'=>$item_name[$key]]);
            $total = $total+$quantitys[$key]*$prices[$key];
        }
        $order->total = $total;
        $order->balance = $total;
        $order->save();
        DB::commit();
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(order $order)
    {
        return view('order.order_ship',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
//        dd(1);
        DB::beginTransaction();
        $order->status='n';
        foreach ($order->items as $item){
            $item->pivot->status='s';
            $item->pivot->save();
        }
        $order->save();
        DB::commit();
        return redirect()->back();
    }

    /*
     * mark order items as shipped
     * */
    public function order2ship(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'order_id'=>'required'
        ]);
        DB::beginTransaction();
        $order = Order::find($request->input('order_id'));
        foreach ($request->input('id') as $id){
            $order->items()->updateExistingPivot($id,['status'=>'s']);
        }
        DB::commit();
        return redirect(url('agencys',[$order->agency->id]));

    }

    /*
     * pay balance of specific order*/
    public function order2pay(Request $request){
        $this->validate($request,[
            'order_id'=>'required',
            'amount'=>'numeric | min:0.5'
        ]);
        DB::beginTransaction();
        $order = Order::find($request->input('order_id'));
        $balance = $order->balance - $request->input('amount');
        $order->balance = $balance>0?$balance:0;
        $order->save();
        DB::commit();
        return redirect()->back();
    }
}
