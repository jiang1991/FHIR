<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::post('/user/login', 'LoginController@UserLogin');

Route::post('/user/signin', 'UserController@login');

Route::any('/mypatient/{id}', 'MyController@MyPatient');

Route::any('/myobservation/{id}', 'ObservationController@MyObservation');

Route::any('/plot/{id}', 'PlotController@Plot');

/* Fhir Create * Create = POST https://example.com/path/{resourceType} */
Route::post('observation', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\ObservationController@ObservationCreate'
  ]);

/* Fhir Read * Read = GET https://example.com/path/{resourceType}/{id} */
Route::get('observation/{observation}', 'Fhir\ObservationController@ObservationRead');

/* Fhir Update * Update = PUT https://example.com/path/{resourceType}/{id} */

/* Fhir Delete * Delete = DELETE https://example.com/path/{resourceType}/{id} */

/* Search * Search = GET https://example.com/path/{resourceType}?search parameters.. */

/* Create Patient*/
Route::post('patient', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\PatientController@PatientCreate'
  ]);

/* Read Patient*/
Route::get('patient/{patient}', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\PatientController@PatientRead'
  ]);

/* shareTo*/
Route::post('shareto', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@shareTo'
  ]);

/* 查询分享
* return all shared patient
* 没有则返回空json
*/
Route::get('shareto', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@getShare'
]);

/* search */
Route::get('search', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\SearchController@Search'
  ]);

/* pulsebit O2 update service */
Route::get('update', 'Update\UpdateController@update');
