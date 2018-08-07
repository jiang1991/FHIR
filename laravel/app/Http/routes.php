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

Route::post('/user/login', 'LoginController@UserLogin');

Route::post('/user/signup', 'UserController@signup');

Route::any('/mypatient/{id}', 'MyController@MyPatient');

Route::get('/myobservation/{id}', 'ObservationController@MyObservation');
Route::delete('/myobservation/{id}', 'ObservationController@destroy');

Route::any('/plot/{id}', 'PlotController@Plot');


// emails
Route::get('emails/notification/{id}', 'email\MailController@notification');


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
Route::get('patient/{patient}', 'Fhir\PatientController@PatientRead');

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
Route::get('search/{param}', [
  'middleware' => 'auth.basic',
  'uses' => 'Fhir\SearchController@Search'
  ]);

/* pulsebit O2 update service -- deprecated */
Route::get('update', 'Update\UpdateController@update');
/* check O2 & O2 Vibe*/
Route::any('update/O2/{region}', 'Update\UpdateController@O2Update');

// bm88
Route::any('update/bodimetrics/{hv}', 'Update\UpdateController@bodimetrics');

// fda/bodimetrics pro
Route::any('update/fda/{hv}', 'Update\UpdateController@fda');

// CE Pro
Route::any('update/ce/{hv}', 'Update\UpdateController@ce');

// JP Pro
Route::any('update/jp/{hv}', 'Update\UpdateController@jp');

// semacare
Route::any('update/semacare/{hv}', 'Update\UpdateController@semacare');

// smartBP
Route::any('update/smartbp/{language}', 'Update\UpdateController@smartbp');

// SnoreO2
Route::any('update/snoreo2/{language}', 'Update\UpdateController@snoreo2');

// test service
Route::any('update/test', 'Update\UpdateController@test');

/* export Excel */
Route::get('excel/export', 'export\ExcelController@export');

Route::get('holter/export/{holter_id}', 'HolterController@export');
Route::get('holter/pdf', 'HolterController@pdf');
Route::get('export/observation/{id}', 'Export\PdfController@export');


// for monitor data upload
Route::any('monitor/upload', 'Fhir\MonitorController@upload');
Route::get('monitor/query', 'Fhir\MonitorController@query');

// redirect
Route::any('redirect/qrcode/{app_name}/{os_name}', 'Update\RedirectController@redirect');
Route::any('redirect/apk_download/{app_name}', 'Update\RedirectController@app_download');
// for pc software
Route::any('apis/time', 'Update\RedirectController@gettime');
Route::any('update/apis/{param}', 'Update\UpdateController@apis');