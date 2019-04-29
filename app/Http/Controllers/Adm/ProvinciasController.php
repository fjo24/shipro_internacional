<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Provincia;
use Maatwebsite\Excel\Facades\Excel;
use App\Pais;

class ProvinciasController extends Controller
{
    public function index()
    {
        $provincias=Provincia::OrderBy('id', 'ASC')->get();
        return view('adm.provincias.index', compact('provincias'));
    }

    public function create()
    {
        $paises=Pais::OrderBy('id', 'ASC')->pluck('pais', 'id')->all();
        return view('adm.provincias.create', compact('paises'));
    }

    public function store(Request $request)
    {
        $provincia       = new Provincia();
        $provincia->fill($request->all());
        $provincia->save();
        return redirect()->route('provincias.index');
    }

    public function edit($id)
    {
        $paises=Pais::OrderBy('id', 'ASC')->get();
        $provincia  = Provincia::find($id);
        return view('adm.provincias.edit', compact('provincia', 'paises'));
    }
    public function update(Request $request, $id)
    {
        $provincia = Provincia::find($id);
        $provincia->fill($request->all());
        $provincia->update();
        return redirect()->route('provincias.index');
    }

    public function destroyprov($id)
    {
        $provincia = Provincia::find($id);
        $provincia->delete();
        return redirect()->route('provincias.index');
    }

    public function excel()
    {
        return view('adm.provincias.carga');
    }

    public function importexcel(Request $request)
    {
       // dd($request->excel);
        Excel::load($request->excel, function($reader) {
 
            foreach ($reader->get() as $book) {

                $provincia = Provincia::Where('codigo', $book->codigo)->first();
                /* $provincia->codigo=$book->codigo; */
                /* $provincia->descripcion=$book->descripcion; */
                $provincia->descripcion_en=$book->descripcion_en;
/*                 $provincia->pais_id='527';//canada */
                $provincia->update();

                /* $destinations = Pais::Where('country', $book->pais)->get();
                if(isset($destinations)) {
                    foreach ($destinations as $destination) {
                        # code...
                        $destination->codigo_pais = $book->codigo_pais;
                        $destination->save();
                    }
                } */
            }
        });
        return redirect()->route('provincias.index');

    }
    
}
