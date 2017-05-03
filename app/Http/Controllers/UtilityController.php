<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UtilityController extends Controller
{
    public function imageUpload(Request $request){
        try{
            $files = $request->allFiles();
            foreach ($files as $file){
                $url = Storage::put('photos',$file);
                return $visibility = Storage::getVisibility($url);
                return Storage::url($url);
            }
        }catch (\Exception $e){
            return 'error|服务器端错误';
        }


    }
}
