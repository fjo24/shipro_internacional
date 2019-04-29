<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Retiro;
use App\Estado;
use Carbon\Carbon;
use App\Traits\Consultar;

class OrdersController extends Controller
{
    use Consultar;
    public function index(Request $request)
    {
        $estados = Estado::orderBy('nombre', 'ASC')->pluck('nombre', 'id')->all();
        $currier  = $request->get('currier');
        $tracking  = $request->get('tracking');
        $destinatario  = $request->get('destinatario');
        $fechamayor  = $request->get('fechamayor');
        if (isset($fechamayor)) {
            $fechamayor = Carbon::parse($fechamayor)->format('Y-m-d');
        }
        $fechamenor  = $request->get('fechamenor');
        if (isset($fechamenor)) {
            $fechamenor = Carbon::parse($fechamenor)->format('Y-m-d');
        }
        $servicio  = $request->get('servicio');
        $estado  = $request->get('estado');
        $estadoshipro  = $request->get('estado_id');
        $retiros = Retiro::OrderBy('fecha_hora', 'DESC')->where('internacional', 1)
            ->with('comprador')
            ->with('estadoshipro')
            ->currier($currier)
            ->tracking($tracking)
            ->destinatario($destinatario)
            ->fechamayor($fechamayor)
            ->fechamenor($fechamenor)
            ->servicio($servicio)
            ->estado($estado)
            ->filtroestadoshipro($estadoshipro)
            ->paginate();

    /*     foreach ($retiros as $reti){
            $seguimiento = $reti->seguimiento;
            if ($reti->ProveedorShipro == 'UPS') {
                $datos=array("username" => "D2581C52941FD262CCAF51172F934C84943691814227D9B7AEE55B6182E3   B9408503175DD8E63A3D0EEE84F96D69CBDF57AA227B071511C902A5BB3FCC444AB5", 
                "password"=>
                "398773FA6CFFB5A94080A80B3C6234196E14B037B6312742027F53AA9AC67601B622455A60F78F4CF2790509C296B4741E3FEC623DD6C2C898DC32CB8CA1228F", "seguimiento"=>$seguimiento, "tracking" => $reti->trackingProveedor);
                $arrayups = $this->TrackUps($datos);
                if($arrayups['estado']!=null){
                    $reti->estado = $arrayups['estado'];
                    $reti->update();
                }
            }elseif ($reti->ProveedorShipro == 'FEDEX') {
                $arrayfedex = $this->TrackFedex($seguimiento);
                $reti->update();
            }
        } */

  /*       $tasks = Task::orderBy('id', 'DESC')->paginate(3);

        return [
            'pagination' => [
                'total' => $tasks->total(),
                'current_page' => $tasks->currentPage(),
                'per_page' => $tasks->perPage(),
                'last_page' => $tasks->lastPage(),
                'from' => $tasks->firstItem(),
                'to' => $tasks->lastItem(),
            ],
            'tasks' => $tasks 
        ];
 */
        return view('adm.orders.index', compact('retiros', 'estados'));
    }

    public function etiqueta($id)
    {
        $retiro = Retiro::find($id);

        //API PARA GENERAR ETIQUETA
        $ids = array();
        array_push($ids, array(
            "id" => $retiro->trackingProveedor
        ));

        $datos_etiqueta = array(
            "username" => "D2581C52941FD262CCAF51172F934C84943691814227D9B7AEE55B6182E3B9408503175DD8E63A3D0EEE84F96D69CBDF57AA227B071511C902A5BB3FCC444AB5",
            "password" =>
            "398773FA6CFFB5A94080A80B3C6234196E14B037B6312742027F53AA9AC67601B622455A60F78F4CF2790509C296B4741E3FEC623DD6C2C898DC32CB8CA1228F",
            "cp_origen" => $retiro->sender->cp,
            "cp_destino" => $retiro->comprador->cp,
            "proveedor" => $retiro->ProveedorShipro,
            "ids" => $ids
        );
        $headers = array('Accept: application/json', 'Content-Type: application/json');
        //$headers= array('Content-Type: application/json');
        $data_string_etiqueta = json_encode($datos_etiqueta);
        /* dd($data_string_etiqueta); */
        $ch = curl_init();
        $url_local = 'http://localhost/shipro/etiqueta.php';
        $url_desarrollo = 'http://desarrollo.shipro.pro/shipro/etiqueta_internacional.php';
        $url_produccion = "http://motos.epresis.com/shipro_internacional/etiqueta.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_desarrollo);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string_etiqueta);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result_etiqueta = curl_exec($ch);
        /* dd($result_etiqueta); */
        curl_close($ch);
        $array_etiqueta = json_decode($result_etiqueta, true);
        /* dd($result_etiqueta); */
        /* dd($array_etiqueta); */
        /* $decoded_etiqueta = base64_decode($array_etiqueta['png']);*/
        $file = $retiro->trackingProveedor . '.png';

        $url = 'http://desarrollo.shipro.pro/shipro/etiqueta_ups/' . $file;
        return \Redirect::to($url);

        return view('adm.orders.guide', compact('retiro'));
    }

    public function voucher($id)
    {
        $retiro = Retiro::find($id);

        //API PARA GENERAR VAUCHER
        $ids = array();
        array_push($ids, array(
            "id" => $retiro->trackingProveedor
        ));

        $datos_voucher = array(
            "username" => "D2581C52941FD262CCAF51172F934C84943691814227D9B7AEE55B6182E3B9408503175DD8E63A3D0EEE84F96D69CBDF57AA227B071511C902A5BB3FCC444AB5",
            "password" =>
            "398773FA6CFFB5A94080A80B3C6234196E14B037B6312742027F53AA9AC67601B622455A60F78F4CF2790509C296B4741E3FEC623DD6C2C898DC32CB8CA1228F",
            "cp_origen" => $retiro->sender->cp,
            "cp_destino" => $retiro->comprador->cp,
            "proveedor" => $retiro->ProveedorShipro,
            "ids" => $ids
        );
        $headers = array('Accept: application/json', 'Content-Type: application/json');
        //$headers= array('Content-Type: application/json');
        $data_string_voucher = json_encode($datos_voucher);
        //dd($data_string_voucher);
        $ch = curl_init();
        $url_local = 'http://localhost/shipro/etiqueta.php';
        $url_desarrollo = 'http://desarrollo.shipro.pro/shipro/voucher_internacional.php';
        /* $url_desarrollo = 'http://desarrollo.shipro.pro/shipro/voucher_internacional.php'; */
        $url_produccion = "http://motos.epresis.com/shipro_internacional/etiqueta.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_desarrollo);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string_voucher);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result_voucher = curl_exec($ch);
        curl_close($ch);
        $array_voucher = json_decode($result_voucher, true);
        //dd($array_voucher['png']);
        $decoded_voucher = base64_decode($array_voucher['png']);
        $file = $retiro->trackingProveedor . '.png';
        if ($retiro->ProveedorShipro == 'UPS') {
            $url = 'http://desarrollo.epresis.com/shipro/etiqueta_ups/' . $file;
            return \Redirect::to($url);
        }

        //FIN API PARA GENERAR VAUCHER

        return view('adm.orders.guide', compact('retiro'));
    }

    public function sendmail(Request $request)
    {
        $mensaje = $request->mensaje;
        $retiro = Retiro::find($request->idretiro);
        Mail::send('adm.orders.email', ['retiro' => $retiro, 'mensaje' => $mensaje], function ($message) use ($retiro) {

            $message->from('fm@shipro.pro', 'Shipro Internacional');
            $message->to($retiro->comprador->email);
            //Add a subject
            $message->subject('consulta shipro');
        });
        return redirect()->route('ordenes');
    }

    public function guide($id)
    {
        $retiro = Retiro::find($id);
        return view('adm.orders.guide', compact('retiro'));
    }
}
