<?php

use Illuminate\Support\Facades\Route;
use Yandex\Geocode\Facades\YandexGeocodeFacade;
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


return;

Route::get('/{any}',function (){
    return view('index');
})->where('any','.*');



