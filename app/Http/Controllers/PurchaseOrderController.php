<?php

namespace App\Http\Controllers;

use App\Purchase_order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $this->validate($request,[
            'items'=>'required',
            'supplier'=>'required',
            'supplier_order'=>'required'
        ]);
        DB::beginTransaction();
        $purchase_order = Purchase_order::create($request->all());
        $items = $request->input('items');
        $items = json_decode($items,true);
        $total = 0;

        if($request->has('status')){
            foreach ($items as $key=>$value){

                $purchase_order->items()->attach($key,['quantity'=>$value[0],'price'=>$value[1],'status'=>'a']);
                $total += $value[0]*$value[1];
            }
        }else{
            foreach ($items as $key=>$value){
                $purchase_order->items()->attach($key,['quantity'=>$value[0],'price'=>$value[1]]);
                $total += $value[0]*$value[1];
            }
        }
        $purchase_order->total = $total;
        $purchase_order->save();
        DB::commit();
        return redirect('purchase_orders');


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
                $suppliers = Purchase_order::select('supplier')->groupBy('supplier')->pluck('supplier','supplier')->all();
                $data = session(Input::get('s'));
                $data = json_decode($data,true);
                return view('purchase.purchase_review',compact('data','suppliers'));
            }else{
                return redirect('purchase_orders');
            }
        }else{
            return redirect('purchase_orders');
        }
    }
}
