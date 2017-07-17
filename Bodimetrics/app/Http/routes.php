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

Route::get('/home', 'HomeController@index');

// setting
Route::get('/setting', 'SettingController@index');


Route::get('/mypatient/{id}', 'MyController@MyPatient');

/* delete account */
Route::delete('/account', 'MyController@destroy');

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

// download binary file for ecg & sleep
Route::get('fhir/observation/download/{observation_id}', 'Fhir\ObservationController@download');


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


// RI question
Route::post('fhir/ri', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\RiController@Ri'
]);


