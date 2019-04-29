<?php

namespace App\Http\Controllers\Externos\Envios;

use Illuminate\Http\Request;
use App\Http\Controllers\Couriers\ApisController;

class ConsultarPagoController extends ApisController
{
    public function consultar(Request $request)
    {
	
    	$datos = $request->json()->all();
    	$data_json = json_encode($datos);
    	$array_pago = json_decode($data_json, true);

    	$pago = array(
            "id" => $array_pago['pago'][0]['id'],
            "confirmacion_url" => $array_pago['pago'][0]['confirmacion_url'],
            "referencia_shipro" => $array_pago['pago'][0]['referencia_shipro'],
            "topic" => $array_pago['pago'][0]['topic']
        );

        $data=array("pago" => $pago);

        $mercadopago = $this->consultarpago($data);
        dd($mercadopago);

        return response()->json($mercadolibre);
    }
}
