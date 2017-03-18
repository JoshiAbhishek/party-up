<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Illuminate\Http\Request;

class APIController extends Controller
{
    //
	public function testController()
	{
		$client = new Client();
		$res = $client->request('GET', 'https://staging-api.moj.io/v1/users/me?MojioAPIToken=148b745f-67aa-4ab5-89b2-ca61b4f4a222', [
		]);
		$result = json_decode($res->getBody()->getContents());
		dd($result);

		$this->blade_data['test'] = "nothing";
		return view('pages.testpage', $this->blade_data);	
	}
}
