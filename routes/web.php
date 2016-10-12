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

Route::get('/', function () {
    $tasks = \App\Model\Task::all();
    foreach($tasks as $task)
    {
        var_dump($task);exit;
    }
    return view('welcome');
});

Route::get('tasks/', 'TaskController@show');