<?php

namespace App\Http\Controllers\Externos\Envios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pais;
use App\Cordon;
use App\Datosprestador;
use App\Sender;
use App\Sucursal;
use App\Cpcordon;
use App\Servicio;
use App\Datosenvio;
use App\User;
use Carbon\Carbon;
use App\Retiro;
use App\Provincia;
use App\Producto;
use App\Comprador;
use Illuminate\Support\Facades\Session;
use App\Cliente;
use App\Traits\Crearenvio;

class CrearEnvioController extends Controller
{
    use Crearenvio;
    public function CreateShipment(Request $request){ 
        /* Session::flush(); */
        /* dd($request->precio); */
        $datos = $request->json()->all();
    	$data_json = json_encode($datos);
    	$array_servicios = json_decode($data_json, true);
    	$sucursal = Sucursal::Where('codigo_sucursal', $array_servicios['remitente'][0]['codigo_sucursal'])->first();

        $registro = new Comprador();
        $registro->localidad = $array_servicios['destinatario'][0]['localidad'];
        $registro->provincia = $array_servicios['destinatario'][0]['provincia'];
        $registro->apellido_nombre = $array_servicios['destinatario'][0]['destinatario'];
        $registro->altura = $array_servicios['destinatario'][0]['altura'];
        $registro->piso = $array_servicios['destinatario'][0]['piso'];
        $registro->dpto = $array_servicios['destinatario'][0]['dpto'];
        $registro->numero_documento = $array_servicios['destinatario'][0]['cuit'];
        $registro->tipo_documento_id = 1;
        $registro->calle = $array_servicios['destinatario'][0]['calle'];
        $registro->cp = $array_servicios['destinatario'][0]['cp'];
        $registro->email = $array_servicios['destinatario'][0]['email'];
        $registro->celular = $array_servicios['destinatario'][0]['telefono'];
        $registro->other_info = $array_servicios['destinatario'][0]['otra_info'];
        $registro->externo = 1;
        $registro->save();
        /* dd($request); */
        if(isset($sucursal->provincia->codigo)){
            $codigo_provincia = $sucursal->provincia->codigo;
        }else{
            $codigo_provincia = null;
        }
        
        $remitente = array(
            "sucursal" => $sucursal->descripcion,
            "calle" => $sucursal->calle,
            "altura" => $sucursal->altura,
            "cp" => $sucursal->cp,
            "codigo_provincia"=> $codigo_provincia,
            "provincia"=> $sucursal->provincia,
            "pais" => $sucursal->pais->iata_pais,
            "telefono" => $sucursal->celular
        );
        
        $destinatario = array(
            "destinatario" => $array_servicios['destinatario'][0]['destinatario'],
            'tipo_documento' => 1,
            "numero_documento" => $array_servicios['destinatario'][0]['cuit'],
            "calle" => $array_servicios['destinatario'][0]['calle'],
            "altura" => $array_servicios['destinatario'][0]['altura'],
            "piso" => $array_servicios['destinatario'][0]['piso'],
            "dpto" => $array_servicios['destinatario'][0]['dpto'],
            "otra_info" => $array_servicios['destinatario'][0]['otra_info'],
            "cp" => $array_servicios['destinatario'][0]['cp'],
            "email" => $array_servicios['destinatario'][0]['email'],
            "telefono" => $array_servicios['destinatario'][0]['telefono'],
            "localidad" => $array_servicios['destinatario'][0]['localidad'],
            "provincia"=> $array_servicios['destinatario'][0]['provincia'], //entra o el nombre de la provincia o el codigo del estado
            "codigo_provincia"=> $array_servicios['destinatario'][0]['codigo_estado'],
            "pais" => $array_servicios['destinatario'][0]['codigo_pais']
        );

        $paquete = array();
        array_push($paquete, array(
            "tipo_paquete" => "01",
            "valor_fob" => $array_servicios['paquete'][0]['valor_fob_usd'],
            "peso" => $array_servicios['paquete'][0]['peso'],
            "fragil" => null,
            "largo" => $array_servicios['paquete'][0]['largo'],
            "ancho" => $array_servicios['paquete'][0]['ancho'],
            "alto" => $array_servicios['paquete'][0]['alto']
            )    
        );
        $servicio = Servicio::Where('codigo_servicio', $array_servicios['servicio'][0]['id'])->first();
        $servicio = array(
        	"id" => $servicio->descripcion,
            "proveedor" => $array_servicios['servicio'][0]['proveedor']
        );

        $data=array(
            "remitente" => $remitente, 
            "destinatario" => $destinatario, 
            "paquete" => $paquete, 
            "servicio" => $servicio
        );

        $rules = [
            'remitente.cp' => 'max:8|required',
            'remitente.sucursal' => 'required',
            'destinatario.cp'      => 'max:8|required',
            'destinatario.destinatario'      => 'required',
            'destinatario.numero_documento'      => 'required',
            'destinatario.telefono'      => 'required',
            'destinatario.localidad'      => 'required',
            'destinatario.telefono'      => 'required',
            'destinatario.pais'      => 'required',
            'paquete.0.valor_fob' => 'required',
            'paquete.0.largo' => 'required|numeric',
            'paquete.0.ancho' => 'required|numeric',
            'paquete.0.alto' => 'required|numeric',
            'paquete.0.peso' => 'required|numeric',
            'servicio.id' => 'required',
            'servicio.proveedor' => 'required'
            ];
        $validator = \Validator::make($data, $rules);
        if ($validator->fails()) {
            return [
                'created' => false,
                'errors'  => $validator->errors()->all()
            ];
        }
        
        $fecha = Carbon::now();
        $proveedor = $array_servicios['servicio'][0]['proveedor'];
        $pais_origen = Pais::Where('iata_pais', $sucursal->pais->iata_pais)->first();
        $pais_destino = Pais::Where('iata_pais', $array_servicios['destinatario'][0]['codigo_pais'])->first();
        
        if ($proveedor=='FEDEX') {
            $respuesta = $this->CreateShipmentFedex($data);
        }
        
        if ($proveedor=='UPS') {
            $respuesta = $this->CreateShipmentUps($data);
        }

        /* dd($respuesta); */
        $sucursal=Sucursal::Where('descripcion', $sucursal->descripcion)->first();
        $cliente= $sucursal->cliente;

        $current_user = User::Where('cliente_id', $cliente->id)->first();
        $datosenvio = new Datosenvio();
        $datosenvio->peso = $array_servicios['paquete'][0]['peso'];
        $datosenvio->fecha = $fecha;
        $datosenvio->save();
        $retiro= new retiro();
        /*$retiro->comprador_id = $array_servicios['destinatario'][0]['id'];*/
        $retiro->pais_origen = $pais_origen->pais;
        $retiro->pais_destino = $pais_destino->pais;
        $retiro->sucursal_id = $sucursal->id;
        $retiro->fecha_hora = $fecha;
        $retiro->internacional = 1;
        $retiro->seguimiento = mt_rand(0000000001, 9999999999);
        $retiro->etiqueta = $respuesta['url'];
        $retiro->servicio_id = $respuesta['id'];
        $retiro->comprador_id = $registro->id;
//sa
        $retiro->precio=$respuesta['precio'];
        $retiro->peso=$array_servicios['paquete'][0]['peso'];
        $provincia_destino = Provincia::Where('codigo', $array_servicios['destinatario'][0]['codigo_estado'])->first();
        if ($provincia_destino!=null) {
            $retiro->provinciadestino_id = $provincia_destino->id;
        }else{
            $retiro->provinciadestino_id = null;
        }
        $retiro->trackingProveedor=$respuesta['tracking'];
        $retiro->servicioShipro = $array_servicios['servicio'][0]['id'];
        $retiro->proveedorShipro = $proveedor;
        if ($array_servicios['destinatario'][0]['fragil']="on"){
            $retiro->is_fragil = 1;
        }else {
            $retiro->is_fragil = 0;
        }
        $retiro->user_id = $current_user->id;
        $retiro->valor_declarado = $array_servicios['paquete'][0]['valor_fob_usd'];

        $retiro->save();

        $producto = new Producto();
        $producto->retiro_id = $retiro->id;
        $producto->largo = $array_servicios['paquete'][0]['largo'];
        $producto->alto = $array_servicios['paquete'][0]['alto'];
        $producto->ancho = $array_servicios['paquete'][0]['ancho'];
        $producto->peso = $array_servicios['paquete'][0]['peso'];
        $producto->peso_volumetrico = $array_servicios['paquete'][0]['peso'];
        $producto->forma_carga = "01";
        $producto->save();

        $servicio = Servicio::find($retiro->servicio_id);

        $array_resultados=array(
            "servicio" => $servicio->codigo_servicio, 
            "seguimiento" => $retiro->seguimiento, 
            "tracking" => $retiro->trackingProveedor, 
            "moneda" => "USD", "precio" => $retiro->precio, 
            "url" => "internacional.shipro.pro".$retiro->etiqueta
        );

        /* Session::flush(); */
        return response()->json($array_resultados);
        $comprador1 = Comprador::Where('id', $retiro->comprador_id)->first();
        return view('couriers.guide', compact('retiro', 'comprador', 'sender', 'comprador1'));
    }
}
