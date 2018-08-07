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

Route::post('/user/login', 'LoginController@UserLogin');

Route::post('/user/signup', 'LoginController@SignUp');

// setting
Route::get('/setting', 'SettingController@index');

/* delete account */
Route::delete('/account', 'MyController@destroy');

Route::get('/mypatient/{id}', 'MyController@MyPatient');

Route::get('/myobservation/{id}', 'ObservationController@MyObservation');
Route::delete('/myobservation/{id}', 'ObservationController@destroy');

Route::any('/plot/{id}', 'PlotController@Plot');


/* Terms */
Route::get('/terms', function(){
  return view('page.terms');
} );

/* privacy */
Route::get('/privacy', function(){
    return view('page.privacy');
} );


/* Fhir Create * Create = POST https://example.com/path/{resourceType} */
Route::post('observation', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\ObservationController@ObservationCreate'
  ]);

/* Fhir Read * Read = GET https://example.com/path/{resourceType}/{id} */
Route::get('observation/{observation}', 'Fhir\ObservationController@ObservationRead');


// patient
Route::post('patient', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\PatientController@PatientCreate'
  ]);
Route::get('patient/{patient_id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\PatientController@PatientRead'
  ]);
Route::get('patient/search/{medical_id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\PatientController@Search'
  ]);

// share
Route::post('shareto', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@shareTo'
  ]);
Route::get('shareto', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@getShare'
]);
Route::post('shareto/delete', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@destroy'
]);
Route::get('shareto/query/{patient}', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\shareToController@query'
]);

/* search */
Route::get('search/patient', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\SearchController@patientSearch'
  ]);

Route::get('search/{patient_id}/observation', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\SearchController@ObservationSearch'
  ]);


/* export */
Route::get('export/observation/{id}', 'Export\PdfController@export');
Route::get('export/excel/observation/{id}', 'Export\ExcelController@export');

// download binary file for ecg & sleep
Route::get('observation/download/{observation_id}', 'Fhir\ObservationController@download');

/* apis for test */
Route::get('test/users', 'Fhir\TestController@user');
Route::get('test/notice', 'Fhir\TestController@api');


// app update
Route::any('update/app/{os}/{app}', 'Update\AppupdateConstroller@app');
Route::any('update/query', 'Update\AppQueryController@query');