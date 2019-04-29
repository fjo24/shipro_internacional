<?php

namespace App\Http\Controllers\Externos\Envios;

use Illuminate\Http\Request;
use App\Http\Controllers\Couriers\ApisController;

class CheckoutController extends ApisController
{
    public function Confirm(Request $request)
    {
	
    	$datos = $request->json()->all();
    	$data_json = json_encode($datos);
    	$array_compra = json_decode($data_json, true);

    	$remitente = array(
    		/* "id_usuario" => $array_compra['remitente'][0]['id'], */
            "sucursal" => $array_compra['remitente'][0]['sucursal'],
            "calle" => $array_compra['remitente'][0]['calle'],
            "altura" => $array_compra['remitente'][0]['altura'],
            "piso" => $array_compra['remitente'][0]['piso'],
            "dpto" => $array_compra['remitente'][0]['dpto'],
            "otra_info" => $array_compra['remitente'][0]['otra_info'],
            "cp" => $array_compra['remitente'][0]['cp'],
            "email" => $array_compra['remitente'][0]['email'],
            "telefono" => $array_compra['remitente'][0]['telefono'],
            "localidad" => $array_compra['remitente'][0]['localidad'],
            "provincia"=> $array_compra['remitente'][0]['provincia'], //entra o el nombre de la provincia o el codigo del estado
            "codigo_provincia"=> $array_compra['remitente'][0]['codigo_estado'],
            "pais" => $array_compra['remitente'][0]['codigo_pais']
        );
        
        $destinatario = array(
            /* "id" => $array_compra['destinatario'][0]['id'], */
            "destinatario" => $array_compra['destinatario'][0]['destinatario'],
            'tipo_documento' => 1,
            "numero_documento" => $array_compra['destinatario'][0]['cuil'],
            "calle" => $array_compra['destinatario'][0]['calle'],
            "altura" => $array_compra['destinatario'][0]['altura'],
            "piso" => $array_compra['destinatario'][0]['piso'],
            "dpto" => $array_compra['destinatario'][0]['dpto'],
            "otra_info" => $array_compra['destinatario'][0]['otra_info'],
            "cp" => $array_compra['destinatario'][0]['cp'],
            "email" => $array_compra['destinatario'][0]['email'],
            "telefono" => $array_compra['destinatario'][0]['telefono'],
            "localidad" => $array_compra['destinatario'][0]['localidad'],
            "provincia"=> $array_compra['destinatario'][0]['provincia'], //entra o el nombre de la provincia o el codigo del estado
            "codigo_provincia"=> $array_compra['destinatario'][0]['codigo_estado'],
            "pais" => $array_compra['destinatario'][0]['codigo_pais']
        );

        $paquete = array();
        array_push($paquete, array(
            "tipo_paquete" => "01",
            "valor_fob" => $array_compra['paquete'][0]['valor_fob_usd'],
            "peso" => $array_compra['paquete'][0]['peso'],
            "fragil" => null,
            "largo" => $array_compra['paquete'][0]['largo'],
            "ancho" => $array_compra['paquete'][0]['ancho'],
            "alto" => $array_compra['paquete'][0]['alto']
	        )
	    );

        $franja = "tarde";

        $servicio = array(
            "id" => $array_compra['servicio'][0]['id'],
            "proveedor" => $array_compra['servicio'][0]['proveedor'],
            "descripcion" => $array_compra['servicio'][0]['descripcion'],
            "externa" => "si",
            "precio" => $array_compra['servicio'][0]['precio']
        );
        $data=array("remitente" => $remitente, "destinatario" => $destinatario, "paquete" => $paquete, "servicio" => $servicio);
        
        $mercadolibre = $this->GenerarPagoExterno($data);

        return response()->json($mercadolibre);
    }
}
