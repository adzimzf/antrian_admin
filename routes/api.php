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

Route::post("/login",       "API\AuthController@login");
Route::post("/register",    "API\AuthController@register");

Route::group(['middleware' => 'ApiAuth'], function (){
   Route::post('/logout',        "API\AuthController@logout");
});

Route::group(["prefix"=>"rs"], function (){
    Route::get("get/{name?}/{poly?}", "API\RSController@getByNameAndPoly");
    Route::get("getjadwal/{id}", "API\RSController@getJadwalByName");
});
Route::group(["prefix"=>"poly"], function (){
    Route::get("get", "API\PolyController@get");
});
Route::group(["prefix"=>"antrian"], function () {
    Route::post("set", "API\AntrianController@set");
});