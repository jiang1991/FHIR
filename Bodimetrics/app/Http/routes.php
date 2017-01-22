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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index');

Route::auth();

// admin
Route::get('/viatomadmin', 'AdminController@index');
Route::delete('/viatomadmin/{id}', 'AdminController@destroy');

Route::get('/home', 'HomeController@index');

Route::get('/mypatient/{id}', 'MyController@MyPatient');

Route::get('/myobservation/{id}', 'ObservationController@MyObservation');
Route::delete('/myobservation/{id}', 'ObservationController@destroy');

Route::any('/plot/{id}', 'PlotController@Plot');



// FHIR api

Route::post('/user/login', 'LoginController@UserLogin');

Route::post('/user/signup', 'LoginController@SignUp');

/* Fhir Create * Create = POST https://example.com/path/{resourceType} */
Route::post('fhir/observation', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\ObservationController@ObservationCreate'
  ]);

/* Fhir Read * Read = GET https://example.com/path/{resourceType}/{id} */
Route::get('fhir/observation/{observation}', 'Fhir\ObservationController@ObservationRead');

/* Fhir Update * Update = PUT https://example.com/path/{resourceType}/{id} */

/* Fhir Delete * Delete = DELETE https://example.com/path/{resourceType}/{id} */

/* Search * Search = GET https://example.com/path/{resourceType}?search parameters.. */

// patient
Route::post('fhir/patient', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\PatientController@PatientCreate'
  ]);
Route::get('fhir/patient/{patient_id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\PatientController@PatientRead'
  ]);
Route::get('fhir/patient/search/{medical_id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\PatientController@Search'
  ]);

// share
Route::post('fhir/shareto', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@shareTo'
  ]);
Route::get('fhir/shareto', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@getShare'
]);
Route::post('fhir/shareto/delete', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@destroy'
]);
Route::get('fhir/shareto/query/{patient}', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@query'
]);

/* search */
Route::get('fhir/search/patient', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\SearchController@patientSearch'
  ]);

Route::get('fhir/search/{patient_id}/observation', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\SearchController@ObservationSearch'
  ]);


// attachment
Route::post('fhir/attachment', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\AttachmentController@upload'
  ]);

Route::get('fhir/attachment/{attachment_id}', 'Fhir\AttachmentController@download');