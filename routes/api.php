<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::prefix('v1/')->group(function () {

    Route::post('login','LoginController@login')->name('api.v1.login');


    Route::prefix('geocoder/')->group(function (){

        Route::get('locality','GeocoderController@locality')->name('api.v1.geocoder.locality');

        Route::get('street','GeocoderController@street')->name('api.v1.geocoder.street');

        Route::get('search','GeocoderController@search')->name('api.v1.geocoder.search');
    });



    // this group only auth user
    Route::middleware(['auth:sanctum'])->group(function (){

        Route::post('logout','LoginController@logout')->name('api.v1.logout');

        Route::resource('apikey','ApiKeyController')->only(['index','destroy','store','show']);

    });
});
