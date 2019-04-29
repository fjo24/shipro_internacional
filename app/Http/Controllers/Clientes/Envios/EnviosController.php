<?php

namespace App\Http\Controllers\Clientes\Envios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Fos_user;
use App\Tipo_documento;
use App\Pais;
use App\Retiro;
use Carbon\Carbon;
use App\Provincia;
use Illuminate\Support\Facades\Input;
use App\Comprador;
use App\Sucursal;
use App\Traits\Consultar;

class EnviosController extends Controller
{
    use Consultar;
    public function index()
    {
        //listados de retiros en donde esta involucrado el usuario
        $retiros = Retiro::OrderBy('fecha_hora', 'DESC')->with('comprador')->Where('user_id', Auth()->user()->id)->where('internacional', 1)->get();
        //Actualiczacion de estados
        foreach ($retiros as $reti) {
            $seguimiento = $reti->seguimiento;
            if ($reti->ProveedorShipro == 'UPS') {
                # code...
                $datos=array("username" => "D2581C52941FD262CCAF51172F934C84943691814227D9B7AEE55B6182E3   B9408503175DD8E63A3D0EEE84F96D69CBDF57AA227B071511C902A5BB3FCC444AB5", 
                "password"=>
                "398773FA6CFFB5A94080A80B3C6234196E14B037B6312742027F53AA9AC67601B622455A60F78F4CF2790509C296B4741E3FEC623DD6C2C898DC32CB8CA1228F", "seguimiento"=>$seguimiento, "tracking" => $reti->trackingProveedor);
                $arrayups = $this->TrackUps($datos);

                if($arrayups['estado']!=null){
                    $reti->estado = $arrayups['estado'];
                    //primera fecha
                    $reti->update();
                }
            }elseif ($reti->ProveedorShipro == 'FEDEX') {
                $arrayfedex = $this->TrackFedex($seguimiento);
                /* dd($arrayfedex); */
                $reti->update();
            }
        }
        
        return view('clientes.envios.index', compact('retiros'));
    }

    public function create()
    {
        $sucursales = Sucursal::Where('cliente_id', Auth()->user()->cliente_id)->get();
        $sucursal = Auth()->user()->sucursal;
        $cliente = Auth()->user()->cliente;
        $usuario = Fos_user::Where('id', 23)->first();
        $tipo_docs = Tipo_documento::OrderBy('id', 'ASC')->pluck('nombre', 'id')->all();
        $fecha = Carbon::now()->format('d/m/Y');
        $countries2 = Pais::OrderBy('pais', 'ASC')->pluck('pais', 'id')->all();
        $countries = Pais::OrderBy('pais', 'ASC')->pluck('pais', 'iata_pais')->all();
        $destinatarios = $cliente->compradores()->Where('agenda', 1)->get();
        
        return view('clientes.envios.create', compact('sucursales','sucursal', 'destinatarios', 'countries', 'countries2', 'usuario', 'fecha', 'tipo_docs'));
    }

    public function etiqueta_fedex($id)
    {
        $retiro = Retiro::find($id);
        $path     = public_path();
        $url      = $path . '/' . $retiro->etiqueta;
        return response()->download($url);
    }

    public function etiqueta_ups($id)
    {
        $retiro = Retiro::find($id);
        $path     = public_path();
        $url      = $path . '/' . $retiro->etiqueta;
        return response()->download($url);
    }

    public function select_provincias(Request $request)
    {
        $codigo_pais=Input::get('codigo_pais');
        $pais=Pais::Where('id',$codigo_pais)->first();
        $provincias=Provincia::OrderBy('descripcion', 'ASC')->where('pais_id','=',$pais->id)->get();
        if (isset($provincias)) {
            return response()->json($provincias);
        }else{
            $provincias = null;
            return response()->json($provincias);
        }
    }
    
    public function select_destinatarios(Request $request)
    {
        $destinatario_id=Input::get('id');
        $destinatario=Comprador::Where('id',$destinatario_id)->first();
        $paises=Pais::OrderBy('id', 'ASC')->get();
        if (isset($destinatario)) {
            return response()->json(["destinatario" => $destinatario, "paises" => $paises]);
        }else{
            $destinatario = null;
            return response()->json($destinatario);
        }
    }

    public function select_sucursales(Request $request)
    {
        $sucursal_id=Input::get('id');
        $sucursal=Sucursal::Where('id',$sucursal_id)->first();
        if (isset($sucursal)) {
            return response()->json($sucursal);
        }else{
            $sucursal = null;
            return response()->json($sucursal);
        }
    }
    
    public function destinatarios(Comprador $comprador)
    {
/*         $comprador = Comprador::Where('cliente_id', Auth()->user()->cliente_id)->get(); */
        return $comprador;
    }
    public function show($id)
    {
        $retiro = retiro::find($id);
        return view('clientes.envios.show', compact('retiro'));
    }

}
