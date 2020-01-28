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

Route::apiResource('contacts', 'ContactsController');
Route::apiResource('solar_projects', 'SolarProjectsController');
Route::get('/solar_projects/{solar_project}/contacts', 'SolarProjectContactsController@index');
Route::put('/solar_projects/{solar_project}/contacts', 'SolarProjectContactsController@update');
