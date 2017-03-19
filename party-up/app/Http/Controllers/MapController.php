<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
	public function getMap($group_id) {
		$this->blade_data['group_id'] = $group_id;
		$this->blade_data['nothing'] = 'nothing';
		return view('pages.map', $this->blade_data);
	}
}
