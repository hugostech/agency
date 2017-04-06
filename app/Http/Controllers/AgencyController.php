<?php

namespace App\Http\Controllers;

use App\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AgencyController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Input::has('s')){
            $search = '%'.Input::get('s').'%';
            $agencys = Agency::where('wechat','like',$search)->where('user_id',Auth::user()->id)->paginate(15);
        }else{
            $agencys = Agency::where('user_id',Auth::user()->id)->paginate(15);
        }
        return view('agency.agency',compact('agencys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('agency.agency_add');
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
            'wechat'=>'required | unique:agencys'
        ]);
        DB::beginTransaction();
            Agency::create($request->all());
        DB::commit();
        return redirect('agencys');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function show(Agency $agency)
    {

        $orders = $agency->orders()->where('status','y')->orderBy('created_at','desc')->get();

        return view('agency.agency_detail',compact('orders','agency'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function edit(Agency $agency)
    {
        return view('agency.agency_edit',compact('agency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agency $agency)
    {
        $this->validate($request,[
            'wechat'=>'required | unique:agencys'
        ]);
        $agency->update($request->all());
        return redirect('agencys');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agency  $agency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agency $agency)
    {
        //
    }
}
