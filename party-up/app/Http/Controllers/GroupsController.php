<?php

namespace App\Http\Controllers;

use App\Models\groups;
use App\Models\memberships;
use App\Models\locations;
use App\Models\vehicles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;

$access_token = "117889f4-5f79-472d-968a-7536e40db815";

class GroupsController extends DataController
{

    public function setBroadcast(Request $request) {
        $request->session()->put('access_token', '$access_token');
        $id = $request->session()->get('user_id')->_id;
        $user = User::find($id);
        if($user->broadcasting==1) {
            $user->broadcasting = 0;
        } else {
            $user->broadcasting = 1;
        }
        $user->save();
    }

	public function stopBroadcast() {
		$id = 1;
		$user = User::find($id);
		$user->broadcasting = 0;
		$user->save();
	}

    // Get id of currently logged in user
    public function getUserGroups(Request $request) {
        $request->session()->put('access_token', '$access_token');
        $user_id = $this->fetchCurrentUser()->_id;
	
	$this->updateData();	

        $id = User::select('id','user_id')->where('user_id',$user_id)->first()->id;

        $request->session()->put('user_id', $id);

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
			$first_name = User::where('username', $member->username)->first()->first_name;
			$last_name = User::where('username', $member->username)->first()->last_name;
            $cars[] = [$member->username,$member->broadcasting,$member->lat,$member->lng, $first_name, $last_name];
        }

        $this->blade_data['cars'] = $cars;
		$this->blade_data['nothing'] = 'nothing';
		return view('pages.map', $this->blade_data);
	}

    public function createGroup(Request $request) {
        $request->session()->put('access_token', '$access_token');
        $id = $request->session()->get('user_id')->_id;
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

    public function joinGroup(Request $request) {
        $id = $request->session()->get('user_id')->_id;
        $member = new memberships;
        $member->user_id = $id;
        $code = Input::get('code');
        $group = groups::where('group_code',$code)->first();

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
