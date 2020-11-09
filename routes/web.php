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
    return view('index');
});

Route::get('/best', function () {
    return view('best');
});

Route::get('/ranking', function () {
    return view('ranking');
});

Route::prefix('excel')->group(function () {
    Route::get('/', 'ReporteController@index');
    Route::post('/save', 'ReporteController@saveReport');
    Route::get('/download/{id}', 'ReporteController@generateExcel');
});
