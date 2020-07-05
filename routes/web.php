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

Route::any('tasks.list', 'TaskController@list')->name('tasks.list');

Route::any('tasks.search', 'TaskController@search')->name('tasks.search');

Route::any('priorities.search', 'PriorityController@search')->name('priorities.search');
Route::any('statuses.search', 'StatusController@search')->name('statuses.search');


Route::post('users', 'UserController@search')->name('users');

Route::get('tasks.calendar', 'TaskController@calendar')->name('tasks.calendar');

});    