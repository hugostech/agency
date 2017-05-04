<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Item;
use Illuminate\Validation\Rules\In;

class ClientControlller extends Controller
{
    public function index(Request $request){
        $this->validate($request,[
            'wechat'=>'required | exists:agencys,wechat'
        ]);
        $request->session()->put('client',$request->input('wechat'));
        return redirect('client/search');
    }

    public function show(){
        if (Session::has('client')){
            return redirect('client/search');
        }else{
            return view('client.index');
        }

    }

    public function logout(Request $request){
        $request->session()->forget('client');
        return redirect('wechat');
    }

    public function search(){
        if (Session::has('client')){
            $item = null;
            if (Input::has('i')){
                $item = Item::find(Input::get('i'));
            }
            return view('client.search',compact('item'));
        }else{
            return redirect('wechat');
        }

    }

    /**
     *Search items by key word
     * @param string $key
     * @return array
     */
    public function itemSearch($key){
        $result = array();
        $items = Item::where('make','like',"%$key%")->orWhere('name','like',"%$key%")->where('status','y')->get();

        foreach ($items as $item){
            if ($item->price > 0){
                $result[$item->id] = $item->make.' '.$item->name;
            }

        }
        return json_encode($result);
    }
}
