<?php

namespace App\Http\Controllers;

use App\Purchase_order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchase_orders = Purchase_order::paginate(30);
        return view('purchase.purchase', compact('purchase_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchase.purchase_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase_order $purchase_order
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase_order $purchase_order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase_order $purchase_order
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase_order $purchase_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Purchase_order $purchase_order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase_order $purchase_order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase_order $purchase_order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase_order $purchase_order)
    {
        //
    }

    /*
     * entry supplier and supplier no
     * @param Request $request
     * @return \Illuminate\Http\Response
     * */
    public function newOrder2(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $unid = bcrypt(uniqid());
        $data = array();
        $ids = $request->input('id');
        $quantitys = $request->input('quantity');
        $prices = $request->input('price');
        foreach ($ids as $key => $id) {
            $data[$id] = array($quantitys[$key], $prices[$key]);
        }
        $data = json_encode($data);
        $request->session()->put($unid, $data);
        $url = url('purchase_orders',['review']).'?s='.$unid;
        return redirect($url);
    }

    /*
     * list purchase order detail and supplier info entry
     * @return \Illuminate\Http\Response
     * */
    public function purchaseReview(){
        if(Input::has('s')){
            if (session(Input::get('s'))){
                $data = session(Input::get('s'));
                $data = json_decode($data);
            }else{
                return redirect('purchase_orders');
            }
        }else{

        }
    }
}
