<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MojioLoginController extends Controller
{
    public function test($access_token){
        dd($access_token);
    }
}
