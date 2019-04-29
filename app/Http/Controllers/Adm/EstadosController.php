<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Estado;

class EstadosController extends Controller
{
    public function index()
    {
        $estados=Estado::OrderBy('id', 'ASC')->get();
        return view('adm.estados.index', compact('estados'));
    }

    public function create()
    {
        return view('adm.estados.create');
    }

    public function store(Request $request)
    {
        $estado       = new Estado();
        $estado->fill($request->all());
        $estado->save();
        return redirect()->route('estados.index');
    }

    public function edit($id)
    {
        $estado  = Estado::find($id);
        return view('adm.estados.edit', compact('estado'));
    }
    public function update(Request $request, $id)
    {
        $estado = Estado::find($id);
        $estado->fill($request->all());
        $estado->update();
        return redirect()->route('estados.index');
    }
    public function eliminar($id)
    {
        $estado = Estado::find($id);
        $estado->delete();
        return redirect()->route('estados.index');
    }

}
