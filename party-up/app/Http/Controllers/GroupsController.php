<?php

namespace App\Http\Controllers;

use App\Models\groups;
use App\Models\memberships;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;

class GroupsController extends Controller
{

	/*
	public function getGroups() {
		// For Testing Purposes
		$Groups = array('Group 1', 'Group 2', 'Group 3', 'Group 4');
		$this->blade_data['groups'] = $Groups;
		return view('pages.groups', $this->blade_data);
	}
	*/

    // Get id of currently logged in user
    public function getUserGroups() {
        $id = 1;
        $groups = memberships::
                    join('groups','memberships.group_id','=','groups.id') ->
                    where('user_id',$id) ->
                    select('group_name')->get();
        $names = array();
        foreach($groups as $group) {
            $names[] = $group->group_name;
        }
		$this->blade_data['groups'] = $names;
		return view('pages.groups', $this->blade_data);
    }

    public function createGroup() {
        $id = 1;
        $group = new groups;
        $group->group_name = Input::get('name');
        $group->save();
        $this->joinGroup($group->id);
        return Redirect::to('/Groups');
    }

    public function updateDestination($id,$loc_id) {
        $group = groups::find($id);
        $group->destination_id = $loc_id;
        $group.save();
    }

    public function joinGroup($group_id) {
        $user_id = 1;
        $member = new memberships;
        $member->user_id = $user_id;
        $member->group_id = $group_id;
        $member->save();
    }

    public function leaveGroup() {

    }
}
