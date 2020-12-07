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

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', 'HomeController@loginCheck');

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home.index');

Route::get('/hitung', 'HitungController@index')->middleware('auth')->name('hitung.index');

Route::get('/kriteria', 'KriteriaController@index')->middleware('auth')->name('kriteria.index');

Route::get('/alternatif', 'AlternatifController@index')->middleware('auth')->name('alternatif.index');

