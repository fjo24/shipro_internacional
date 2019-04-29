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
use App\User;
Route::get('error', function(){
    abort(500);
    });
Route::get('/', function () {
    return view('welcome');
});
Route::get('plantilla', function () {
    return view('plantilla');
});

Auth::routes();
/*******************ACCESO CLIENTEsS************************/
Route::middleware('auth')->group(function () {
    Route::resource('destinatarios', 'Clientes\Destinatarios\DestinatariosController');
    Route::get('destinatarios/{id}/eliminar', ['uses' => 'Clientes\Destinatarios\DestinatariosController@eliminar',
            'as'   => 'destinatarios.eliminar',]);
    //news
    Route::resource('envios', 'Clientes\Envios\EnviosController', ['only' => ['index', 'create', 'show']]);
    Route::post('envios/servicios', 'Clientes\Envios\ServiciosController@servicios')->name('servicios');
    Route::get('crearenvio', 'Clientes\Envios\CrearEnvioController@CrearEnvio')->name('crearenvio');
    Route::post('envios/mercadopago', 'Clientes\Envios\MercadopagoController@mercadopago')->name('mercadopago');
    
/*     Route::post('/notificaciones', 'Apis\ApisController@notificaciones')->name('notificaciones');
 */    Route::get('etiqueta_fedex/{id}', ['uses' => 'Clientes\Envios\EnviosController@etiqueta_fedex', 'as' => 'etiqueta_fedex']);
    //etiqueta ups aun no funciona
    Route::get('etiqueta_ups/{id}', ['uses' => 'Clientes\Envios\EnviosController@etiqueta_ups', 'as' => 'etiqueta_ups']);
    //old
    Route::get('/home', 'HomeController@index')->name('home');
    //select dependiente ajax
    Route::get('json-paises','Clientes\Envios\EnviosController@select_provincias');
    Route::get('json-destinatarios', 'Clientes\Envios\EnviosController@select_destinatarios');
    Route::get('destinatarios-json/{id}', 'Clientes\Envios\EnviosController@destinatarios');
    Route::get('json-sucursales', 'Clientes\Envios\EnviosController@select_sucursales');

});
/* Route::get('destinatarios', function () {
    $users = User::get();
    return $users;
}); */
/*******************ACCESO ADMIN************************/
Route::get('admin/routes', 'Adm\AdminController@dashboard')->middleware('admin');

Route::prefix('adm')
    ->middleware('admin')
    ->middleware('auth')->group(function () {
        /*------------TIPO DE DOCUMENTOS----------------*/
        Route::resource('documents', 'Adm\DocumentsController')
            //->middleware('admin')
        ;

        Route::get('documents/{id}/destroy', [
            'uses' => 'Adm\DocumentsController@destroydoc',
            'as'   => 'documents.destroydoc',
        ]);

        /*------------RETIROS ----------------*/
        Route::resource('retiros', 'Adm\RetirosController');
        Route::get('/lista-retiros', ['uses' => 'Adm\RetirosController@listado', 'as' => 'retiros.listado']);
        
        /*------------ESTADOS ----------------*/
        Route::resource('estados', 'Adm\EstadosController');
        Route::get('estado/{id}/eliminar', ['uses' => 'Adm\EstadosController@eliminar',
            'as'   => 'estado.eliminar',]);

        /*------------ CP DE CORDONES ----------------*/
        Route::resource('cpcordones', 'Adm\CpcordonesController');
        Route::get('cpcordon/{id}/eliminar', ['uses' => 'Adm\CpcordonesController@eliminar',
            'as'   => 'cpcordones.eliminar',]);

        /*------------ ORDENES ADMINISTRADOR CON SCOPES ----------------*/
        Route::get('/', 'Adm\OrdersController@index')->name('ordenes');
        
        //enviar email al destinatario
        Route::post('enviar-mailcontacto', [
            'uses' => 'Adm\OrdersController@sendmail',
            'as'   => 'sendmail',
        ]);
        //Descargar etiqueta 
        Route::get('etiqueta/{id}', ['uses' => 'Adm\OrdersController@etiqueta','as'=> 'etiqueta',]);
        
        //Descargar etiqueta 
        Route::get('voucher/{id}', ['uses' => 'Adm\OrdersController@voucher','as'=> 'voucher',]);

        /*------------ VER GUIA ----------------*/
        Route::get('guia/{id}/ver', [
            'uses' => 'Adm\OrdersController@guide',
            'as'   => 'guideadm',
        ]);

        /*------------DESTINATIONS ----------------*/
        Route::resource('destinations', 'Adm\DestinationsController')
            //->middleware('admin')
        ;
        
        /*-----CARGA DE EXCELS PARA DESTINOS-----------*/
        Route::get('excel_destinations', ['uses' => 'Adm\DestinationsController@excel', 'as' => 'excel_destinations']);
        Route::post('/import-excel', 'Adm\DestinationsController@importexcel')->name('importexcel');
        
        Route::get('destinations/{id}/destroy', [
            'uses' => 'Adm\DestinationsController@destroydes',
            'as'   => 'destinations.destroydes',
        ]);
        /*------------PROVINCIAS ----------------*/
        Route::resource('provincias', 'Adm\ProvinciasController');

        Route::get('provincia/{id}/destroy', [
            'uses' => 'Adm\ProvinciasController@destroyprov',
            'as'   => 'provincias.destroyprov',
        ]);
        
        /*-----CARGA DE EXCELS PARA PROVINCIAS-----------*/
        Route::get('excel_provincias', ['uses' => 'Adm\ProvinciasController@excel', 'as' => 'excel_provincias']);
        Route::post('/import-excel-provincias', 'Adm\ProvinciasController@importexcel')->name('importexcelprovincias');
    });

