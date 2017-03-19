<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\groups;

class MapController extends Controller
{
	public function getMap($group_id) {
		$this->blade_data['group_id'] = $group_id;
        $group = groups::find($group_id);
        $this->blade_data['group_name'] = $group->group_name;
        $this->blade_data['group_code'] = $group->group_code;
		$this->blade_data['nothing'] = 'nothing';
		return view('pages.map', $this->blade_data);
	}
}
