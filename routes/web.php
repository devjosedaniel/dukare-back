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


Route::resource('modelo', 'ModeloController');
Route::resource('moto', 'MotoController');
Route::resource('usuario', 'UsuarioController');
Route::post('autenticar','AuthController@validar');
Route::post('moto/busqueda/{texto}','MotoController@search');
Route::post('moto/subir','MotoController@subirArchivo');
Route::get('reporte','MotoController@reporte');
Route::get('reporteRegistro','MotoController@reporteRegistro');
Route::get('inventario','MotoController@inventario');