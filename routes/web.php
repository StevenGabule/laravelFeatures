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
    return view('welcome');
});
Route::get('events', 'EventsController@index')->name('events.index');
Route::post('events', 'EventsController@addEvent')->name('events.add');


Route::resource('sample', 'SampleController');
Route::post('sample/update', 'SampleController@update')->name('sample.update');
Route::get('sample/destroy/{id}', 'SampleController@destroy');

