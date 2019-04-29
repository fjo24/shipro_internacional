<?php

namespace App\Http\Controllers\Clientes\Envios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Servicio;
use App\Traits\Pago;

class MercadopagoController extends Controller
{
    use Pago;
    public function Mercadopago(Request $request)
    {
        $data = Session::get('data');
        $servicio = Servicio::Where('descripcion', $request->descripcion)->first();
        $franja = "tarde";
        $servicio = array(
            "id" => $servicio->descripcion,
            "proveedor" => $request->proveedor,
            "externa" => "no",
            "franja" => $franja,
            "precio" => $request->precio
        );
        $data = array_add($data, 'servicio', $servicio);
        $mercadolibre = $this->generatePaymentGateway($data);
        $data = array_add($data, 'mercadopago', $mercadolibre);
 
        Session::flush();
        Session::put('data', $data);
        return view('clientes.envios.mercadopago', compact('data'));
    }
}
