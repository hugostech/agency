<?php

namespace App\Http\Controllers;

use App\order;
use Illuminate\Http\Request;
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
        foreach ($ids as $key=>$id){
            var_dump($id);
//            $order->items()->attach($id,['quantity'=>$quantitys[$key],'price'=>$prices[$key],'status'=>'p']);

            $order->items()->attach($id,['quantity'=>$quantitys[$key],'price'=>$prices[$key],'status'=>'p']);
            $total = $total+$quantitys[$key]*$prices[$key];
        }
        $order->total = $total;
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
}
