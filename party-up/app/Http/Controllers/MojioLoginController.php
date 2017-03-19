<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Redirect;
use Carbon\Carbon;

class MojioLoginController extends Controller
{
    public function setSession(Request $request){
        return Redirect::to('http://localhost:8000/Groups');
    }
}
