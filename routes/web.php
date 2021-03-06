<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('tasks.calendar');
    
});

Auth::routes();

Route::resource('tasks', 'TaskController');
Route::resource('priorities', 'PriorityController');
Route::resource('statuses', 'StatusController');

Route::resource('users', 'UserController');

Route::group(['middleware' => ['auth']], function(){

    Route::get('/home', 'HomeController@index')->name('home');

    Route::any('tasks.search/{filter}', 'TaskController@search')->name('tasks.search');

    Route::any('tasks.tags/{tag}', 'TaskController@tags')->name('tasks.tags');

    Route::any('priorities.search', 'PriorityController@search')->name('priorities.search');

    Route::any('statuses.search', 'StatusController@search')->name('statuses.search');

    Route::post('users', 'UserController@search')->name('users');

    Route::get('tasks.calendar', 'TaskController@calendar')->name('tasks.calendar');

    Route::get('tasks.complete/{id}', 'TaskController@complete')->name('tasks.complete');

    Route::post('/tasks_store_from_calendar',['uses' => 'TaskController@store_from_calendar'])->name('tasks.store_from_calendar');
});    
