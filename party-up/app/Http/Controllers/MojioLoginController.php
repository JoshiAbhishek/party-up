<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Redirect;

class MojioLoginController extends Controller
{
    public function test(Request $request, $access_token, $expires_in){
        dd($access_token);
        dd($expires_in);
        $request->session()->put('access_token', $access_token);
        $request->session()->put('expire_time', Carbon::now()->addSeconds($expires_in));
        
        echo($request->session()->get('expire_time')->toTimeString());
        //return Redirect::to('/groups');
    }
}
