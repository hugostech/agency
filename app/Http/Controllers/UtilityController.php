<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UtilityController extends Controller
{
    public function imageUpload(Request $request){
        try{
            $files = $request->allFiles();
            foreach ($files as $file){

                $extension = $file->getClientOriginalExtension();
                $name = uniqid().'.'.$extension;
                $file->move(public_path('photos'),$name);
                return \url('photos',[$name]);

            }
        }catch (\Exception $e){
            return 'error|服务器端错误';
        }


    }
}
