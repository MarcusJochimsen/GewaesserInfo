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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'WaterController@index')->name('water.index');
Route::get('/home', 'WaterController@index')->name('water.index');
Route::get('/water', 'WaterController@index')->name('water.index');
Route::get('/water/markers', 'WaterController@markers')->name('water.markers');
Route::get('/water/create', 'WaterController@create')->name('water.create');
Route::get('/water/{water}', 'WaterController@show')->name('water.show');
Route::get('/water/{water}/edit', 'WaterController@edit')->name('water.edit');
Route::get('/water/{water}/print', 'WaterController@print')->name('water.print');

Route::post('/water', 'WaterController@store')->name('water.store');
Route::patch('/water/{water}', 'WaterController@update')->name('water.update');
Route::delete('/water/{water}', 'WaterController@delete')->name('water.delete');


Route::get('/water/{water}/danger', 'DangerController@index')->name('danger.index');
Route::get('/water/{water}/danger/markers', 'DangerController@markers')->name('danger.markers');
Route::get('/water/{water}/danger/create', 'DangerController@create')->name('danger.create');
Route::get('/water/{water}/danger/{danger}', 'DangerController@show')->name('danger.show');
Route::get('/water/{water}/danger/{danger}/edit', 'DangerController@edit')->name('danger.edit');

Route::post('/water/{water}/danger', 'DangerController@store')->name('danger.store');
Route::patch('/water/{water}/danger/{danger}', 'DangerController@update')->name('danger.update');
Route::delete('/water/{water}/danger/{danger}', 'DangerController@delete')->name('danger.delete');


Route::get('/water/{water}/driveway', 'DrivewayController@index')->name('driveway.index');
Route::get('/water/{water}/driveway/markers', 'DrivewayController@markers')->name('driveway.markers');
Route::get('/water/{water}/driveway/create', 'DrivewayController@create')->name('driveway.create');
Route::get('/water/{water}/driveway/{driveway}', 'DrivewayController@show')->name('driveway.show');
Route::get('/water/{water}/driveway/{driveway}/edit', 'DrivewayController@edit')->name('driveway.edit');

Route::post('/water/{water}/driveway', 'DrivewayController@store')->name('driveway.store');
Route::patch('/water/{water}/driveway/{driveway}', 'DrivewayController@update')->name('driveway.update');
Route::delete('/water/{water}/driveway/{driveway}', 'DrivewayController@delete')->name('driveway.delete');


//Route::get('/user', 'UserController@edit')->name('user.edit');
//Route::get('/user/{user}', 'UserController@index')->name('user.show');

//Route::patch('/user', 'UserController@update')->name('user.update');
//Route::delete('/user', 'UserController@delete')->name('user.delete');

Auth::routes(['confirm' => false]);
