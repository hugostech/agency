<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $s = null;


        if(Input::has('s')){
            $s = trim(Input::get('s'));
            $search = '%'.$s.'%';
            $items = Item::where('make','like',$search)
                        ->orWhere('name','like',$search)
                        ->where('user_id',Auth::user()->id)
//                        ->where('status','y')
                        ->paginate(15);
        }else{
            $items = Item::where('user_id',Auth::user()->id)->where('status','y')->paginate(15);
        }
        return view('item.item',compact('items','s'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item.item_add');
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
            'make'=>'required',
            'name'=>'required | unique:items'
        ]);
        DB::beginTransaction();
        Item::create($request->all());
        DB::commit();
        return redirect('items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('item.item_edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
//        dd($request->all());
        $this->validate($request,[
            'make'=>'required',
            'name'=>'required'
        ]);
        DB::beginTransaction();

        $item->update($request->all());
        DB::commit();
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {

        $item->status = $item->status == 'n'? 'y' : 'n';
        $item->save();
        return redirect('items');
    }

    /**
    *Search items by key word
    * @param string $key
    * @return array
    */
    public function search($key){
        $result = array();
        $items = Item::where('make','like',"%$key%")->orWhere('name','like',"%$key%")->get();
        foreach ($items as $item){
            $result[$item->id] = $item->make.' '.$item->name;
        }
        return json_encode($result);
    }
}
