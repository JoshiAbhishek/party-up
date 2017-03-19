<?php

namespace App\Http\Controllers;

use App\Models\groups;
use App\Models\memberships;
use App\Models\locations;
use App\Models\vehicles;
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
                    select('group_name','groups.id')->get();
        $names = array();
        foreach($groups as $group) {
            $names[] = [$group->id,$group->group_name];
        }
		$this->blade_data['groups'] = $names;
		return view('pages.groups', $this->blade_data);
    }

	public function getGroupUsers($group_id) {
		$this->blade_data['group_id'] = $group_id;
        $group = groups::find($group_id);
        $group_dest = locations::find($group->destination_id);
        //TODO: not found
        //

        if($group_dest == null) {
            $this->blade_data['group_dest'] = null;
        } else {
            $this->blade_data['group_dest'] = [$group_dest->lat,$group_dest->lng];
        }

        $this->blade_data['group_name'] = $group->group_name;
        $this->blade_data['group_code'] = $group->group_code;

        $this->blade_data['group_dest'] = $group->destination_id;

        $members = memberships::
            join('users','memberships.user_id','=','users.id') ->
            where('group_id',$group_id)->
            select('users.id')->get();
        $user_ids = array();
        foreach($members as $member) {
            $user_ids[] = $member->id;
        }

        $people = vehicles::
            join('locations','location_id','=','locations.id') ->
            join('users','owner_id','=','users.id') ->
            whereIn('users.id',$user_ids)->get();

        $cars = array();
        foreach($people as $member) {
            $cars[] = [$member->username,$member->broadcasting,$member->lat,$member->lng];
        }

        $this->blade_data['cars'] = $cars;
		$this->blade_data['nothing'] = 'nothing';
		return view('pages.map', $this->blade_data);
	}

    public function createGroup() {
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
        $group = groups::find($id);
        $group->destination_id = $loc_id;
        $group.save();
    }

    public function joinGroup() {
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

    }
}
