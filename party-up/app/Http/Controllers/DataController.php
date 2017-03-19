<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class DataController extends APIController
{
    public function updateData(Request $request) {
		parent::checkLoginStatus($request);

        $vehicles = $this->fetchVehicles();
		$users = $this->fetchUsers();

		foreach ($users->Data as $user) {
			$db_user = Models\User::where('user_id', $user->_id)->first();
			if (!$db_user) {
				$db_user = new Models\User;
				$db_user->user_id = $user->_id;
				$db_user->username = $user->UserName;
				$db_user->broadcasting = 0;
				$db_user->first_name = 'first_name';
				$db_user->last_name = 'last_name';
				$db_user->save();
			}
		}

		foreach ($vehicles->Data as $vehicle) {
			$db_vehicles = Models\vehicles::where('vehicle_id', $vehicle->_id)->first();
			if ($db_vehicles != null) {
				$location = Models\locations::where('id', $db_vehicles->location_id)->first();
				$location->lat = $vehicle->LastLocation->Lat;
				$location->lng = $vehicle->LastLocation->Lng;
				$date = $vehicle->LastLocationTime;
				$location->set_on = date('Y-m-d h:i:s', strtotime($date));
				$location->valid = $vehicle->LastLocation->IsValid;
			} else {
				$location = new Models\locations;
				$location->lat = $vehicle->LastLocation->Lat;
				$location->lng = $vehicle->LastLocation->Lng;
				$date = $vehicle->LastLocationTime;
				$location->set_on = date('Y-m-d h:i:s', strtotime($date));
				$location->valid = $vehicle->LastLocation->IsValid;
				$location->save();

				$db_vehicles = new Models\vehicles;
				$db_vehicles->vehicle_id = $vehicle->_id;
				
				// Assume vehicle has an owner with matching ID
				$db_user = Models\User::where('user_id', $vehicle->OwnerId)->first();
				$db_vehicles->owner_id = $db_user->id;				
				$db_vehicles->location_id = $location->id;
				$db_vehicles->save();

			}
		}
    }

    public function getData(Request $request) {
		parent::checkLoginStatus($request);

    }
}
