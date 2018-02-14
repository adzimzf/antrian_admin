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

Auth::routes();
Route::get('/',                 'AuthController@redir');

Route::group(['middleware' => 'MyAuth'], function (){
    Route::get('/profile/{id}',     'AuthController@profile');
    Route::post('/update/profile',  'AuthController@update');
});

Route::group(['middleware' => 'Kasir'], function (){
    Route::post('/update/profile/admin','AuthController@updateAdmin');
    Route::get("/user/list",        'AuthController@userList');
    Route::get("/user/add",         'AuthController@userAdd');
    Route::post("/user/insert",     'AuthController@userInsert');
    Route::get("/user/delete/{id}", 'AuthController@userDelete');
});

Route::group(['prefix'=>'designer','middleware' => 'Designer'], function () {
    Route::get('/insert', 'DesignController@index');
    Route::post('/insert', 'DesignController@insert');
});

Route::group(['prefix'=>'kasir', 'middleware' => 'Kasir'], function () {
    Route::get('data',             'KasirController@getData');
    Route::get("data/ajax",        'KasirController@getAjax');
    Route::get('process/{id}',     'KasirController@getProcess');
    Route::get('detail/{id}',      'KasirController@getDetail');
    Route::post('setharga',        'KasirController@setHarga');
    Route::get('printBon/{id}',    'KasirController@printBon');
});

Route::group(['prefix'=>'operator','middleware' => 'Operator'], function () {
    Route::get('data',             'OperatorController@getData');
    Route::get("data/ajax",        'OperatorController@getAjax');
    Route::get("process/{id}",     'OperatorController@getProcess');
    Route::get("process/setDone/ajax",     'OperatorController@setDone');
});
