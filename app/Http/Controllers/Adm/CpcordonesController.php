<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cpcordon;
use App\Cordon;

class CpcordonesController extends Controller
{
    public function index()
    {
        $cordones=Cpcordon::OrderBy('id', 'ASC')->with('cordon')->get();
        return view('adm.cpcordones.index', compact('cordones'));
    }

    public function create() 
    {
        $cps = Cordon::OrderBy('descripcion', 'ASC')->pluck('descripcion', 'id')->all();
        return view('adm.cpcordones.create', compact('cps'));
    }
    
    public function store(Request $request)
    {
        $cordones       = new Cpcordon();
        $cordones->fill($request->all());
        $cordones->save();
        return redirect()->route('cpcordones.index');
    }
    
    public function edit($id)
    {
        $cps = Cordon::OrderBy('descripcion', 'ASC')->pluck('descripcion', 'id')->all();
        $cordon  = Cpcordon::find($id);
        return view('adm.cpcordones.edit', compact('cordon', 'cps'));
    }
    public function update(Request $request, $id)
    {
        $cordon = Cpcordon::find($id);
        $cordon->fill($request->all());
        $cordon->update();
        return redirect()->route('cpcordones.index');
    }
    public function eliminar($id)
    {
        $cordon = Cpcordon::find($id);
        $cordon->delete();
        return redirect()->route('cpcordones.index');
    }
}
