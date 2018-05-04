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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login/google', 'Auth\LoginController@redirectToGoogleProvider');

Route::get('login/google/callback', 'Auth\LoginController@handleProviderGoogleCallback');

Route::get('/drive', 'DriveController@getDrive');

Route::get('/drive/upload', 'DriveController@uploadFile');

Route::post('/drive/upload', 'DriveController@uploadFile');

Route::get('/drive/create', 'DriveController@create');

Route::get('/drive/delete/{id}', 'DriveController@deleteFile');