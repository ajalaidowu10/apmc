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

Route::view('/', 'app');
Route::view('/{any}', 'app');
Route::view('/{any}/{any1}', 'app');
Route::view('/{any}/{any1}/{any2}', 'app');
Route::view('/{any}/{any1}/{any2}/{any3}', 'app');
Route::view('/{any}/{any1}/{any2}/{any3}/{any4}', 'app');
Route::view('/{any}/{any1}/{any2}/{any3}/{any4}/{any5}', 'app');
Route::view('/{any}/{any1}/{any2}/{any3}/{any4}/{any5}/{any6}', 'app');
