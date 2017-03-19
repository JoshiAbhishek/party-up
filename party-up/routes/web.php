<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@getLogin');

Route::get('/Groups', 'GroupsController@getGroups');

Route::get('/Group/{group_id}/', 'MapController@getMap');

/*
Route::get('/', 'APIController@testController');

Route::get('/getUsers', 'APIController@getUsersController');

Route::get('/getVehicles', 'APIController@getVehiclesController');
*/
