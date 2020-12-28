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

use App\Http\Controllers\DangerController;
use App\Http\Controllers\DrivewayController;
use App\Http\Controllers\WaterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [WaterController::class, 'index'])->name('water.index');
Route::get('/home', [WaterController::class, 'index'])->name('water.index');
Route::get('/water', [WaterController::class, 'index'])->name('water.index');
Route::get('/water/markers', [WaterController::class, 'markers'])->name('water.markers');
Route::get('/water/create', [WaterController::class, 'create'])->name('water.create');
Route::get('/water/{water}', [WaterController::class, 'show'])->name('water.show');
Route::get('/water/{water}/edit', [WaterController::class, 'edit'])->name('water.edit');
Route::get('/water/{water}/print', [WaterController::class, 'print'])->name('water.print');

Route::post('/water', [WaterController::class, 'store'])->name('water.store');
Route::patch('/water/{water}', [WaterController::class, 'update'])->name('water.update');
Route::delete('/water/{water}', [WaterController::class, 'delete'])->name('water.delete');


Route::get('/water/{water}/danger', [DangerController::class, 'index'])->name('danger.index');
Route::get('/water/{water}/danger/markers', [DangerController::class, 'markers'])->name('danger.markers');
Route::get('/water/{water}/danger/create', [DangerController::class, 'create'])->name('danger.create');
Route::get('/water/{water}/danger/{danger}', [DangerController::class, 'show'])->name('danger.show');
Route::get('/water/{water}/danger/{danger}/edit', [DangerController::class, 'edit'])->name('danger.edit');

Route::post('/water/{water}/danger', [DangerController::class, 'store'])->name('danger.store');
Route::patch('/water/{water}/danger/{danger}', [DangerController::class, 'update'])->name('danger.update');
Route::delete('/water/{water}/danger/{danger}', [DangerController::class, 'delete'])->name('danger.delete');


Route::get('/water/{water}/driveway', [DrivewayController::class, 'index'])->name('driveway.index');
Route::get('/water/{water}/driveway/markers', [DrivewayController::class, 'markers'])->name('driveway.markers');
Route::get('/water/{water}/driveway/create', [DrivewayController::class, 'create'])->name('driveway.create');
Route::get('/water/{water}/driveway/{driveway}', [DrivewayController::class, 'show'])->name('driveway.show');
Route::get('/water/{water}/driveway/{driveway}/edit', [DrivewayController::class, 'edit'])->name('driveway.edit');

Route::post('/water/{water}/driveway', [DrivewayController::class, 'store'])->name('driveway.store');
Route::patch('/water/{water}/driveway/{driveway}', [DrivewayController::class, 'update'])->name('driveway.update');
Route::delete('/water/{water}/driveway/{driveway}', [DrivewayController::class, 'delete'])->name('driveway.delete');


//Route::get('/user', 'UserController@edit')->name('user.edit');
//Route::get('/user/{user}', 'UserController@index')->name('user.show');

//Route::patch('/user', 'UserController@update')->name('user.update');
//Route::delete('/user', 'UserController@delete')->name('user.delete');

Auth::routes(['confirm' => false]);
