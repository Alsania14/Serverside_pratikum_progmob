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


// ROUTE API UNTUK LOGIN
    Route::post('/login','api\register@index');
    Route::post('/register','api\register@register');
    Route::post('/tokenfeeder','api\register@tokenFeeder');
// AKHIR

// ROUTE API UNTUK EVENT
    Route::prefix('event')->group(function (){
        Route::post('create','api\EventController@create');
        Route::post('delete','api\EventController@delete');
        Route::post('update','api\EventController@update');
        Route::post('read','api\EventController@read');
        Route::post('myevent','api\EventController@myEvent');

        Route::post('delete','api\EventController@delete');
    });
// AKHIR

// ROUTE API UNTUK DETAILEVENT
    Route::prefix('detailevent')->group(function() {
        Route::post('join','api\DetailEventController@joinEvent');
        Route::post('cancel','api\DetailEventController@cancelJoin');
        Route::post('accept','api\DetailEventController@accept');
        Route::post('denied','api\DetailEventController@denied');
    });
// AKHIR