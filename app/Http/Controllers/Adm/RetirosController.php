<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Retiro;
use App\Estado;
use Carbon\Carbon;

class RetirosController extends Controller
{
    public function listado(Request $request)
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
        return view('adm.retiros.listado');
    }

    public function index(Request $request)
    {
        $retiros = Retiro::orderBy('id', 'DESC')
        ->with('comprador')
        ->with('estadoshipro')
        ->with('servicio')
        ->where('internacional', 1)
        ->paginate(2);

        return [
            'pagination' => [
                'total' => $retiros->total(),
                'current_page' => $retiros->currentPage(),
                'per_page' => $retiros->perPage(),
                'last_page' => $retiros->lastPage(),
                'from' => $retiros->firstItem(),
                'to' => $retiros->lastItem(),
            ],
            'retiros' => $retiros 
        ];

    }
}
