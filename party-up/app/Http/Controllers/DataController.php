<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends APIController
{
    public function updateData() {
        $vehicles = $this->fetchVehicles();
        dd($vehicles);         
    }

    public function getData() {

    }
}
