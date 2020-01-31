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

Route::get('/', 'ConsultoresController@index')->name('index.consultores');
Route::post('/relatorio', 'RelatorioController@index')->name('index.relatorio');
Route::post('/columnas', 'ColumnasController@index')->name('index.columnas');
Route::post('/pizza', 'PizzaController@index')->name('index.pizza');
