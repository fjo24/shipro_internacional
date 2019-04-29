<?php

namespace App\Http\Controllers\Clientes\Envios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pais;
use App\Cordon;
use App\Datosprestador;
use App\Sender;
use App\Sucursal;
use App\Datosenvio;
use Carbon\Carbon;
use App\Retiro;
use App\Provincia;
use App\Producto;
use App\Comprador;
use Illuminate\Support\Facades\Session;
use App\Traits\Crearenvio;

class CrearEnvioController extends Controller
{
use Crearenvio;

    public function CrearEnvio(){
        /* Session::flush(); */
        /* dd($request->precio); */
        $data = Session::get('data');
        $fecha = Carbon::now();
        $proveedor = $data['servicio']['proveedor'];
        $pais_origen = Pais::Where('iata_pais', $data['remitente']['pais'])->first();
        $pais_destino = Pais::Where('iata_pais', $data['destinatario']['pais'])->first();
        $provincia_destino = Provincia::Where('codigo', $data['destinatario']['codigo_provincia'])->first();
        if ($proveedor=='FEDEX') {
            $respuesta = $this->CreateShipmentFedex($data);
        }

        if ($proveedor=='UPS') {
            $respuesta = $this->CreateShipmentUps($data);
        }
        
        $sucursal=Sucursal::Where('descripcion', $data['remitente']['sucursal'])->first();
        $datosenvio = new Datosenvio();
        $datosenvio->peso = $data['paquete'][0]['peso'];
        $datosenvio->fecha = $fecha;
        $datosenvio->save();
        $retiro= new retiro();
        $retiro->comprador_id = $data['destinatario']['id'];

        $retiro->pais_origen = $pais_origen->pais;
        $retiro->pais_destino = $pais_destino->pais;
        $retiro->sucursal_id = $sucursal->id;
        $retiro->fecha_hora = $fecha;
        $retiro->seguimiento = mt_rand(0000000001, 9999999999);
        $retiro->internacional = 1;
        $retiro->datosenvios_id = $datosenvio->id;
        $retiro->etiqueta = $respuesta['url'];
        $retiro->precio=$data['servicio']['precio'];
        $retiro->peso=$data['paquete'][0]['peso'];
        if (isset($data['destinatario']['codigo_provincia'])) {
            $retiro->provinciadestino_id = $provincia_destino->id;
        }else{
            $retiro->provinciadestino_id = null;
        }
        $retiro->trackingProveedor=$respuesta['tracking'];
        $retiro->servicioShipro = $data['servicio']['id'];
        $retiro->proveedorShipro = $proveedor;
        if ($data['destinatario'][0]['fragil']="on"){
            $retiro->is_fragil = 1;
        }else {
            $retiro->is_fragil = 0;
        }
        $retiro->user_id = Auth()->user()->id;
        $retiro->valor_declarado = $data['paquete'][0]['valor_fob'];

        $retiro->save();

        $producto = new Producto();
        $producto->retiro_id = $retiro->id;
        $producto->largo = $data['paquete'][0]['largo'];
        $producto->alto = $data['paquete'][0]['alto'];
        $producto->ancho = $data['paquete'][0]['ancho'];
        $producto->peso = $data['paquete'][0]['peso'];
        $producto->peso_volumetrico = $data['paquete'][0]['peso'];
        $producto->forma_carga = $data['paquete'][0]['tipo_paquete'];
        $producto->save();

        /* Session::flush(); */
        $comprador1 = Comprador::Where('id', $retiro->comprador_id)->first();
        return view('clientes.envios.guia', compact('retiro', 'comprador', 'sender', 'comprador1'));
    }

}
