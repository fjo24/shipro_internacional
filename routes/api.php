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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::resource('servicios', 'Apis\ServiciosController', ['except' => ['create', 'edit']]);
Route::post('/servicios', 'Externos\Envios\ServiciosController@servicios');

/* Route::post('/confirm', 'Externos\Envios\CheckoutController@confirm'); */

//Route::post('/consultarpago', 'Apis\ConsultarPagoController@consultar')->name('consultarpago');

Route::post('/crear-envio', 'Externos\Envios\CrearEnvioController@createshipment');

Route::get('/consultar', 'Externos\Envios\ConsultarEstadoController@consultar');