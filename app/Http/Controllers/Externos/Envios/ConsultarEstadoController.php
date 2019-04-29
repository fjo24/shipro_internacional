<?php

namespace App\Http\Controllers\Externos\Envios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Retiro;
use App\Traits\Consultar;

class ConsultarEstadoController extends Controller
{
    use Consultar;
    public function consultar(Request $request)
    {
    	$datos = $request->json()->all();
    	$data_json = json_encode($datos);
    	$array_envio = json_decode($data_json, true);

        $seguimiento = $array_envio['envio'][0]['seguimiento'];
        //listados de retiros en donde esta involucrado el usuario
        if (Retiro::Where('seguimiento', '=', $seguimiento)->exists()){
        	$retiro = Retiro::Where('seguimiento', '=', $seguimiento)->first();
        //Actualiczacion de estados
        if ($retiro->ProveedorShipro == 'UPS') {
            # code...
            $datos=array("username" => "D2581C52941FD262CCAF51172F934C84943691814227D9B7AEE55B6182E3   B9408503175DD8E63A3D0EEE84F96D69CBDF57AA227B071511C902A5BB3FCC444AB5", 
            "password"=>
            "398773FA6CFFB5A94080A80B3C6234196E14B037B6312742027F53AA9AC67601B622455A60F78F4CF2790509C296B4741E3FEC623DD6C2C898DC32CB8CA1228F", "seguimiento"=>$seguimiento, "tracking" => $retiro->trackingProveedor);
            $arrayups = $this->TrackUps($datos);
            //guardar retiroro
            $retiro->estado = $arrayups['estado'];
            //primera fecha
            $retiro->update();
        }elseif ($retiro->ProveedorShipro == 'FEDEX') {
            $arrayfedex = $this->TrackFedex($seguimiento);
            /* dd($arrayfedex); */
            $retiro->update();
        }
        $respuesta = array("proveedor" => $retiro->ProveedorShipro, "estado" => $retiro->estado, "fecha" => $retiro->fecha_hora, "detalle" => "USD");
        return response()->json($respuesta);
    }else{
    	return response()->json(['error' => 'numero de seguimiento invalido']);
    }
    }
}
