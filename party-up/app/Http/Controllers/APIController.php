<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class APIController extends Controller
{
	public function testController()
	{
		return "Hello";
	}

	/* Max 10 users */
	public function fetchUsers()
	{
		parent::checkLoginStatus();

		$uri_users = 'https://staging-api.moj.io/v1/users?MojioAPIToken=';
		$mojio_api_token = env('APP_MOJIO_TOKEN','');
		$sort = '&limit=10&offset=0&desc=false&sortBy=UserName';

		$client = new Client();
		$res = $client->request('GET', 
			$uri_users . 
			$mojio_api_token . 
			$sort, []);

		$result = json_decode($res->getBody()->getContents());
        return $result;
	}

	/* Max 10 vehicles */
	public function fetchVehicles()
	{
		parent::checkLoginStatus();
		
		$uri_users = 'https://staging-api.moj.io/v1/vehicles?MojioAPIToken=';

		$mojio_api_token = env('APP_MOJIO_TOKEN','');
		$sort = '&limit=10&offset=0&desc=false&sortBy=Name';

		$client = new Client();
		$res = $client->request('GET', 
			$uri_users .
			$mojio_api_token .
			$sort, []);
		$result = json_decode($res->getBody()->getContents());
        return $result;
	}


}
