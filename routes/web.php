<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Auth::routes();
/**
 * Routes in this group only logged in user
 */
Route::group(['middleware' => 'auth'], function () {
    Route::get('date/create/{month}', 'DateController@create');
    Route::get('/dashboard', 'HomeController@index');
    Route::get('/calendar', 'HomeController@calendar');
    Route::get('calendar/{month}-{year}', 'ReservationController@swapMonths');

    Route::post('date/store', 'DateController@store');
    Route::get('date/show/{id}/{available}', 'DateController@showDate');
    Route::post('date/createAllDays', 'DateController@createAllDays');

    Route::post('date/validateReservation/{id}', ['uses' => 'DateController@validation', 'as' => 'date/validateReservation']);

    Route::post('date/destroy/{id}', ['uses' => 'DateController@destroy', 'as' => 'date/destroy']);
    Route::post('date/edit/{id}', ['uses' => 'DateController@edit', 'as' => 'date/edit']);
    Route::post('date/update/{id}', ['uses' => 'DateController@update', 'as' => 'date/update']);
});

/**
 * Normal user routes.
 */
Route::get('/', 'ReservationController@index');
Route::get('/{month}-{year}', 'ReservationController@swapMonths');
Route::post('/', 'ReservationController@jumpToMonth');

Route::get('reservation/create/{id}/{available}', 'ReservationController@createReservation');
Route::post('reservation/store/{id}/{available}', ['uses' => 'ReservationController@storeReservation', 'as' => 'reservation/store']);
