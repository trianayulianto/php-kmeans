<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/perhitungan', 'HitungController@proses_hitung')->name('perhitungan');

Route::get('/kriteria/show', 'KriteriaController@show')->name('getAllKriteria');
Route::post('/kriteria/store', 'KriteriaController@store')->name('storeKriteria');
Route::get('/kriteria/edit', 'KriteriaController@edit')->name('editKriteria');
Route::put('/kriteria/update', 'KriteriaController@update')->name('updateKriteria');
Route::delete('/kriteria/destroy', 'KriteriaController@destroy')->name('destroyKriteria');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
