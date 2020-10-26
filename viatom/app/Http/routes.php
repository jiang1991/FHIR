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
Route::any('/user/destory', [
  'middleware' => 'auth.basic',
  'uses' => 'LoginController@UserDestory'
]);
// 仅删除OxiUpload数据
Route::any('/user/deletedata', [
  'middleware' => 'auth.basic',
  'uses' => 'LoginController@DeleteDate'
]);
// 统计
Route::any('/user/count', [
  'middleware' => 'auth.basic',
  'uses' => 'LoginController@LoginCount'
]);

// order 更新至服务器
Route::post('/order/generate', [
  'middleware' => 'auth.basic',
  'uses' => 'Order\OrderController@generate'
]);
// order 消耗订单
Route::post('/order/consume', [
  'middleware' => 'auth.basic',
  'uses' => 'Order\OrderController@consume'
]);
// order trial
Route::post('/order/trial', [
  'middleware' => 'auth.basic',
  'uses' => 'Order\OrderController@trial'
]);
// order query
Route::any('/order/query',[
  'middleware' => 'auth.basic',
  'uses' => 'Order\OrderController@query'
]);

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

// O2 data upload -- oxiupload
// oxi devices page
Route::any('oxiupload/devices', 'Oxiupload\DevicewebController@devices');
// oxi resources page
Route::any('oxiupload/devices/{device_id}','Oxiupload\DevicewebController@resources');

// create a device
Route::any('oxiupload/device/create',[
  'middleware' => 'auth.basic',
  'uses' => 'Oxiupload\DeviceController@create']);

// query device list by user
Route::any('oxiupload/device/byuser',[
  'middleware' => 'auth.basic',
  'uses' => 'Oxiupload\DeviceController@QuerybyUser']);

// query device info by id
Route::any('oxiupload/device/query/{device_id}',[
  'middleware' => 'auth.basic',
  'uses' => 'Oxiupload\DeviceController@DeviceInfo']);

// create a resource
Route::post('oxiupload/resource/create',[
  'middleware' => 'auth.basic',
  'uses' => 'Oxiupload\OxiuploadController@Create']);

// query resource list by user
Route::any('oxiupload/resource/byuser',[
  'middleware' => 'auth.basic',
  'uses' => 'Oxiupload\OxiuploadController@QuerybyUser']);

// query resource list by device
Route::any('oxiupload/resource/bydevice/{device_id}',[
  'middleware' => 'auth.basic',
  'uses' => 'Oxiupload\OxiuploadController@QuerybyDevice']);

// query resource info by id
Route::any('oxiupload/resource/query/{resource_id}',[
  'middleware' => 'auth.basic',
  'uses' => 'Oxiupload\OxiuploadController@ResourceInfo']);



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
Route::any('update/rtm', 'Update\AppupdateConstroller@rtm');


Route::any('terms-privacy', function(){
  return view('page.terms-yuanzhi');
});



/**
 * for ad apis
 * upload: device type, branchCode, location
 * response: showAd, imgSrc, link, interval
 */
Route::any('apis/ad', 'Ad\AdController@vihealth');


/**
 * Remote Link
 *  -> create
 *  -> delete
 */
Route::any('link/check', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\LinkController@check'
  ]);
Route::any('link/create', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\LinkController@create'
  ]);
Route::any('link/query/{id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\LinkController@queryById'
  ]);
Route::any('link/delete/{id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\LinkController@delete'
  ]);

/**
 * Link query
 *  -> my & shared to me
 *  -> 
 *  -> link shares to others
 */
Route::any('link/share/byUser', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\LinkController@queryByUser'
  ]);
Route::any('link/share/byLink/{id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\LinkController@queryByLink'
  ]);
Route::any('link/share/delete/{id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\CodeController@deleteShare'
  ]);
 /**
  * Link share code
  *  -> create
  *  -> accept
  */
Route::any('link/code/create/{id}', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\CodeController@create'
  ]);
Route::any('link/code/accept', [
  'middleware' => 'auth.basic',
  'uses' => 'Link\CodeController@accept'
  ]);


