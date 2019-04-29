<?php

namespace App\Http\Controllers\Clientes\Destinatarios;

use App\Comprador;
use App\Provincia;
use App\Pais;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DestinatariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinatarios=Comprador::OrderBy('id', 'ASC')->where('cliente_id', Auth::user()->cliente_id)->get();
        return view('clientes.destinatarios.index', compact('destinatarios'));
    }

    public function create()
    {
        $paises = Pais::OrderBy('pais', 'ASC')->pluck('pais', 'id')->all();
        return view('clientes.destinatarios.create', compact('paises'));
    }

    public function store(Request $request)
    {

        $destinatario       = new Comprador();
        $destinatario->apellido_nombre = $request->apellido_nombre;
        $destinatario->celular = $request->celular;
        $destinatario->cuit = $request->cuit;
        $destinatario->pais_id = $request->pais_id;
        if($request->provincia_id!=null){
            $destinatario->provincia_id = $request->provincia_id;
            $provincia = Provincia::Where('id', $request->provincia_id)->first();
            $destinatario->provincia = $provincia->descripcion;
        }else {
            $destinatario->provincia = $request->provincia;
            $destinatario->provincia_id = null;
        }
        $destinatario->altura = $request->altura;
        $destinatario->calle = $request->calle;
        $destinatario->piso = $request->piso;
        $destinatario->cp = $request->cp;
        $destinatario->cliente_id = Auth::user()->cliente_id;

        $destinatario->save();
        return redirect()->route('destinatarios.index');
    }

    public function edit(Comprador $destinatario)
    {
        $paises = Pais::OrderBy('pais', 'ASC')->pluck('pais', 'id')->all();
        return view('clientes.destinatarios.edit', compact('destinatario', 'paises'));
    }
    public function update(Request $request, Comprador $destinatario)
    {
        $destinatario->apellido_nombre = $request->apellido_nombre;
        $destinatario->celular = $request->celular;
        $destinatario->cuit = $request->cuit;
        $destinatario->pais_id = $request->pais_id;
        if($request->provincia_id!=null){
            $destinatario->provincia_id = $request->provincia_id;
            $provincia = Provincia::Where('id', $request->provincia_id)->first();
            $destinatario->provincia = $provincia->descripcion;
        }else {
            $destinatario->provincia = $request->provincia;
            $destinatario->provincia_id = null;
        }
        $destinatario->altura = $request->altura;
        $destinatario->calle = $request->calle;
        $destinatario->piso = $request->piso;
        $destinatario->cp = $request->cp;
        $destinatario->cliente_id = Auth::user()->cliente_id;
        $destinatario->update();
        return redirect()->route('destinatarios.index');
    }
    public function eliminar(Comprador $comprador)
    {
        $comprador->delete();
        return redirect()->route('destinatarios.index');
    }

}
