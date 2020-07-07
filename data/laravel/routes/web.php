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
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/duty-roster/view', 'DutyRosterController@view')->name('duty-roster/view');

Route::get('/duty-roster/setting', 'DutyRosterController@setting')->name('duty-roster/setting');
Route::post('/duty-roster/setting', 'DutyRosterController@setting');

Auth::routes();
