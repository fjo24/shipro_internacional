<?php

namespace App\Http\Controllers\Clientes\Envios;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Comprador;
use Illuminate\Support\Facades\Session;
use App\Sucursal;
use Illuminate\Support\Facades\Auth;
use App\Pais;
use App\Traits\Servicios;

class ServiciosController extends Controller
{
    use Servicios;
    public function servicios(Request $request)
    {   
/*         if ($request->is_fragil="on"){
            $frag = 1;
        }else{
            $frag = 0;
        } */

        /* $rest = $this->ValidarCpFedex(); */
        
        $this->validate($request, [
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
        ]);
            
        if ($request->to_do=="actualizar") {
            $destinatario = Comprador::find($request->destinatarios);
            $destinatario->localidad = $request->localidad2;
            $destinatario->provincia = $request->provincia2;
            $destinatario->apellido_nombre = $request->nombre_apellido2;
            $destinatario->altura = $request->altura2;
            $destinatario->piso = $request->piso2;
            $destinatario->dpto = $request->dpto2;
            $destinatario->numero_documento = $request->numero_documento;
            $destinatario->tipo_documento_id = $request->tipo_documento_id;
            $destinatario->calle = $request->calle2;
            $destinatario->cp = $request->cp2;
            $destinatario->email = $request->email2;
            $destinatario->celular = $request->telephone2;
            $destinatario->other_info = $request->other_info2;
            $destinatario->agenda = 1;
            $destinatario->save();
        }elseif ($request->to_do=="nuevo"){
            $destinatario = new Comprador;
            $destinatario->localidad = $request->localidad2;
            $destinatario->provincia = $request->provincia2;
            $destinatario->apellido_nombre = $request->nombre_apellido2;
            $destinatario->altura = $request->altura2;
            $destinatario->piso = $request->piso2;
            $destinatario->dpto = $request->dpto2;
            $destinatario->numero_documento = $request->numero_documento;
            $destinatario->tipo_documento_id = $request->tipo_documento_id;
            $destinatario->calle = $request->calle2;
            $destinatario->cp = $request->cp2;
            $destinatario->email = $request->email2;
            $destinatario->celular = $request->telephone2;
            $destinatario->other_info = $request->other_info2;
            $destinatario->agenda = 1;
            $destinatario->save();
        }elseif($request->destinatarios!=='x'){
            $destinatario = Comprador::find($request->destinatarios);
        }
     
        $sucursal = Sucursal::find($request->sucursales);
        $pais_destino = Pais::Where('id', $request->destination_id2)->first();
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
            "id" => $destinatario->id,
            "destinatario" => $request->nombre_apellido2,
            'tipo_documento' => $request->tipo_documento_id,
            'numero_documento' => $request->numero_documento,
            "calle" => $request->calle2,
            "altura" => $request->altura2,
            "piso" => $request->piso2,
            "dpto" => $request->dpto2,
            "otra_info" => $request->other_info2,
            "cp" => $request->cp2,
            "email" => $request->email2,
            "telefono" => $request->telephone2,
            "localidad" => $request->localidad2,
            "provincia"=> $request->provincia2, //entra o el nombre de la provincia o el codigo del estado
            "codigo_provincia"=> $request->codigo_provincia2,
            "pais" => $pais_destino->iata_pais
        );

        $paquete = array();
        array_push($paquete, array(
            "tipo_paquete" => $request->tipo,
            "valor_fob" => $request->valor_declarado,
            "peso" => $request->weight,
            "fragil" => $request->is_fragil,
            "largo" => $request->long,
            "ancho" => $request->width,
            "alto" => $request->height
        ));
        $data=array("remitente" => $remitente, "destinatario" => $destinatario, "paquete" => $paquete);

        Session::put('data', $data);
        //Funciones que procesan cotizaciones de servicios
        $arrayfedex = $this->ServiciosFedex($data);
        
        $array_ups = $this->ServiciosUps($data);
        //FIN

        return view('clientes.envios.servicios', compact('array_ups', 'arrayfedex','registro'));
    }

    public function RespuestaServicio(){

    }

}
