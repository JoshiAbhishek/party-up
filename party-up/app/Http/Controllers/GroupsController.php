<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupsController extends Controller
{
	public function getGroups() {
		// For Testing Purposes
		$Groups = array('Group 1', 'Group 2', 'Group 3', 'Group 4');
		$this->blade_data['groups'] = $Groups;
		return view('pages.groups', $this->blade_data);
	}
}
