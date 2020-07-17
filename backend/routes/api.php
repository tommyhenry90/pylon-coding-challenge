<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* Additional Endpoint for deleting multiple Contacts
 - for the sake of simplicity I chose to just extend the existing contacts
   endpoint to also accept a list of uuids (ids={},{}) as a filter and and
   then deletes these records
 - The benefit of this solution is that is remains stateless and only one
   request is required
 - Another option I considered was a 2 step approach:
   * Do a POST to contacts/selections which would return a resource id
   * Do A Delete on this resource id
   However, while this can be argued to be technically more RESTful, the
   added complexity and addition of a second request seems like overkill
*/
Route::delete('/contacts', 'ContactsController@deleteMany');
// See "API resource routes" for more information on this helper:
// https://laravel.com/docs/6.x/controllers#restful-partial-resource-routes
Route::apiResource('contacts', 'ContactsController');
Route::apiResource('solar_projects', 'SolarProjectsController');
// None of the ready-made resource helpers implemented these relationship routes
// the way we want them, so just list them out manually
Route::get('/solar_projects/{solar_project}/contacts', 'SolarProjectContactsController@index');
Route::put('/solar_projects/{solar_project}/contacts', 'SolarProjectContactsController@update');

