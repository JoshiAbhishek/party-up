<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Redirect;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkLoginStatus(Request $request){
        if(!$request->session()->has('access_token')){
            return Redirect::to('/signin')->send();
        }else if(Carbon::now()->gt($request->session()->get('expire_time'))){
            $request->session()->forget('access_token');
            $request->session()->forget('expire_time');
            return Redirect::to('/signin')->send();
        }else{
            // Authenticated
        }
    }
}
