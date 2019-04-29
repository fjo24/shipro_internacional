<?php

namespace App\Http\Controllers\Externos\Envios;

use Illuminate\Http\Request;
use App\Http\Controllers\Couriers\ApisController;
use App\Comprador;
use App\Sucursal;
use App\Servicio;
use App\Traits\Servicios;

class ServiciosController /* extends ApisController */
{
    use Servicios;

    public function servicios(Request $request)
    {
        
    	$datos = $request->json()->all();
    	$data_json = json_encode($datos);
        $array_servicios = json_decode($data_json, true);

        /* $v = Validator::make($request, [
            'sucursal' => 'required',
            'calle' => 'email|required',
            'altura' => 'required',
            'cp' => 'numeric',
            'codigo_provincia' => 'required',
            'provincia' => 'required',
            'pais' => 'required',
            'telefono' => 'required|numeric|digits_between:10,15',
        ]); */

        /* $rules = [
            'nombre_apellido2' => 'required',
            'email2' => 'email|required',
            'telephone2' => 'required|numeric|digits_between:10,15',
            'numero_documento' => 'numeric',
            'localidad2' => 'required',
            'calle2' => 'required',
            'destination_id2' => 'required',
            'cp2' => 'max:8|required',
            'tipo' => 'required',
            'long' => 'required|numeric',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
        ]; */
        
        $sucursal = Sucursal::Where('codigo_sucursal', $array_servicios['remitente'][0]['codigo_sucursal'])->first();
        
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

        $data=array(
            "remitente" => $remitente, 
            "destinatario" => $destinatario, 
            "paquete" => $paquete
        );

        $rules = [
            'remitente.cp' => 'max:8|required',
            'remitente.sucursal' => 'required',
            'destinatario.cp' => 'max:8|required',
            'destinatario.destinatario' => 'required',
            'destinatario.numero_documento' => 'required',
            'destinatario.telefono' => 'required',
            'destinatario.localidad' => 'required',
            'destinatario.telefono' => 'required',
            'destinatario.pais' => 'required',
            'paquete.0.valor_fob' => 'required',
            'paquete.0.largo' => 'required|numeric',
            'paquete.0.ancho' => 'required|numeric',
            'paquete.0.alto' => 'required|numeric',
            'paquete.0.peso' => 'required|numeric',
            ];
        $validator = \Validator::make($data, $rules);
        if ($validator->fails()) {
            return [
                'created' => false,
                'errors'  => $validator->errors()->all()
            ];
        }
        //Funciones que procesan cotizaciones de servicios
        $arrayfedex = $this->ServiciosFedex($data);
        /* dd($arrayfedex); */
        $array_ups = $this->ServiciosUps($data);
        
        dd($arrayfedex['RateReplyDetails']);
		$servicios = array();
        foreach ($arrayfedex['RateReplyDetails'] as $currier) {
            if ($currier['ServiceType']=='INTERNATIONAL_PRIORITY'||$currier['ServiceType']=='INTERNATIONAL_ECONOMY'){
                $servicio = Servicio::Where('descripcion', $currier['ServiceType'])->first();
                array_push($servicios, array(
                    "proveedor" => "FEDEX",
                    "id" => $servicio->codigo_servicio,
                    "servicio" => $currier['ServiceType'],
		            "moneda" => "USD",
		            "precio" => $currier['RatedShipmentDetails']['ShipmentRateDetail']['TotalNetCharge']['Amount'],
		        	)
                    /* isset($currier['DeliveryTimestamp']){
                        "fecha_estimada" => $currier['DeliveryTimestamp']       
                    }; */
		    	);
		    }
		}
        $servicio = Servicio::Where('descripcion', $array_ups['servicion'])->first();
		array_push($servicios, array(
            "proveedor" => "UPS",
            "id" => $servicio->codigo_servicio,
            "servicio" => $array_ups['servicion'],
            "moneda" => "USD",
            "precio" => $array_ups['precio']        
        	)
    	);
        
		return response()->json($servicios);
        //FIN       
        return view('couriers.servicios', compact('array_ups', 'arrayfedex','registro'));
    }
}
