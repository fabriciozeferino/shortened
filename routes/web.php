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

Route::get('/', function () {
    return view('index');
});


Route::get('shorten/fetch', 'ShortenController@fetchWords');
Route::get('shorten/fetchRecentLinks', 'ShortenController@fetchRecentLinks');
Route::put('shorten', 'ShortenController@update');

Route::get('shorten/list', 'ShortenController@list');

Route::any('/{any}', 'ShortenController@listWord')->where('any', '.*');
