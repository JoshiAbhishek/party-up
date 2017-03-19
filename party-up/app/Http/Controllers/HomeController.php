<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

	public function getLogin() {
		$this->blade_data['nothing'] = 'nothing';
		return view('pages.home', $this->blade_data);
    }
}
