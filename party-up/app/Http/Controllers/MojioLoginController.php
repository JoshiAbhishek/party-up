<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MojioLoginController extends Controller
{
    public function test($access_token, $expires_in){
        dd($access_token);
        dd($expires_in);
    }
}
