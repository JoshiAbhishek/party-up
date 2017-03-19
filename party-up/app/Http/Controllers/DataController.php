<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;

class DataController extends APIController
{
    public function updateData() {
        $vehicles = $this->fetchVehicles();
		$users = $this->fetchUsers();

		dd($vehicles);
		foreach ($users as $user) {
			$db_user = Models\Users::where('mojio_id', $user->_id)->first();
			if (!$db_user) {
				$db_user->mojio_id = $user->_id;
				$db_user->username = $user->UserName;
				$db_user->broadcast = false;
				$db_user->first_name = null;
				$db_user->last_name = null;
				$db_user->save();
			}
		}

		foreach ($vehicles as $vehicle) {
			$db_vehicles = Models\vehicles::where('vehicle_id', $vehicle->_id)->first();
			if ($db_vehicles != null) {
				$location = Models\locations::where('id', $db_vehicles->location_id)->first();
				$location->lat = $vehicle->LastLocation->Lat;
				$location->lng = $vehicle->LastLocation->Lng;
				$location->set_on = $vehicle->LastLocationTime;
				$location->valid = $vehicle->LastLocation->IsValid;
			} else {
				$location = new Models\locations;
				$location->lat = $vehicle->LastLocation->Lat;
				$location->lng = $vehicle->LastLocation->Lng;
				$location->set_on = $vehicle->LastLocationTime;
				$location->valid = $vehicle->LastLocation->IsValid;

				$db_vehicles = new Models\vehicles;
				$db_vehicles->vehicle_id = $vehicle->_id;
				$db_vehicles->owner_id = $vehicle->OwnerID;				
				$db_vehicles->location()->save($location);
				$db_vehicles->save();

			}
		}
    }

    public function getData() {

    }
}
