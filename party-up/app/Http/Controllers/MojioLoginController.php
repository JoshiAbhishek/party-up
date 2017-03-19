<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Redirect;
use Carbon\Carbon;

class MojioLoginController extends Controller
{
    public function setSession(Request $request, $access_token, $expires_in){
        $request->session()->put('access_token', $access_token);
        $request->session()->put('expire_time', Carbon::now()->addSeconds(6));

        return Redirect::to('/Groups');
    }
}
