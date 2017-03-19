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
Route::get('/Groups', 'GroupsController@getUserGroups');

Route::get('/Groups/create', function () { return view('pages.groups_create');});
Route::post('/Groups/create', 'GroupsController@createGroup');

Route::post('/Groups/join', 'GroupsController@joinGroup');

Route::get('/Group/{group_id}/', 'GroupsController@getGroupUsers');

Route::get('/getVehicles', 'DataController@updateData');

Route::get('/signin', function () {
    return view('signin');
});

Route::get('/signin/{access_token}/{expires_in}', 'MojioLoginController@setSession');

Route::get('/access', function(){
    return view('access');
});

Route::get('/setBroadcast', 'GroupsController@setBroadcast');

