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

Route::group(['prefix' => 'kriteria'], function () {
    Route::get('/show', 'KriteriaController@show')->name('getAllKriteria');
    Route::post('/store', 'KriteriaController@store')->name('storeKriteria');
    Route::get('/edit', 'KriteriaController@edit')->name('editKriteria');
    Route::put('/update', 'KriteriaController@update')->name('updateKriteria');
    Route::delete('/destroy', 'KriteriaController@destroy')->name('destroyKriteria');
});

Route::group(['prefix' => 'alternatif'], function () {
    Route::get('/show', 'AlternatifController@show')->name('getAllAlternat');
    Route::post('/store', 'AlternatifController@store')->name('storeAlternat');
    Route::get('/edit', 'AlternatifController@edit')->name('editAlternat');
    Route::put('/update', 'AlternatifController@update')->name('updateAlternat');
    Route::delete('/destroy', 'AlternatifController@destroy')->name('destroyAlternat');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
