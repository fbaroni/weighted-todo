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
Route::post('/save/{type}/{date}', 'TaskController@saveTasks')->name('saveTasks')->middleware('auth');
Route::get('/remove/{id}/{type}', 'TaskController@remove')->name('show')->middleware('auth');
Route::get('/', 'TaskController@show')->name('show')->middleware('auth');
