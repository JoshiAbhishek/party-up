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
        this::checkLoginStatus();
        
        $id = 1;
        $groups = memberships::
                    join('groups','memberships.group_id','=','groups.id') ->
                    where('user_id',$id) ->
                    select('group_name','groups.id')->get();
        $names = array();
        foreach($groups as $group) {
            $names[] = [$group->id,$group->group_name];
        }
		$this->blade_data['groups'] = $names;
		return view('pages.groups', $this->blade_data);
    }

	public function getGroupUsers($group_id) {
        this::checkLoginStatus();

		$this->blade_data['group_id'] = $group_id;
        $group = groups::find($group_id);
        $this->blade_data['group_name'] = $group->group_name;
        $this->blade_data['group_code'] = $group->group_code;
        $members = memberships::
            join('users','memberships.user_id','=','users.id') ->
            where('group_id',$group_id)->get();
        $names = array();
        foreach($members as $member) {
            $names[] = [$member->username,$member->broadcasting];
        }
        $this->blade_data['usernames'] = $names;
		$this->blade_data['nothing'] = 'nothing';
		return view('pages.map', $this->blade_data);
	}

    public function createGroup() {
        this::checkLoginStatus();

        $id = 1;
        $group = new groups;
        $group->group_name = Input::get('name');
        $group->group_code = rand(0,999999);
        $group->save();
        $member = new memberships;
        $member->user_id = $id;
        $member->group_id=$group->id;
        $member->save();
 
        return Redirect::to('/Groups');
    }

    public function updateDestination($id,$loc_id) {
        this::checkLoginStatus();

        $group = groups::find($id);
        $group->destination_id = $loc_id;
        $group.save();
    }

    public function joinGroup() {
        this::checkLoginStatus(); 

        $user_id = 1;
        $member = new memberships;
        $member->user_id = $user_id;
        $code = Input::get('code');
        $group = groups::where('group_code',$code)->first();
        
        //TODO: Handle error

        if(!$group) {
        }
        else {
            $member->group_id=$group->id;
            $member->save();
            return Redirect::to('/Groups');
        }
    }

    public function leaveGroup() {
        this::checkLoginStatus();

    }
}
