<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Destination;
use Maatwebsite\Excel\Facades\Excel;
use App\Pais;
//use Excel;

class DestinationsController extends Controller
{
    public function index()
    {
        $destinations=Pais::OrderBy('id', 'ASC')->get();
        return view('adm.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('adm.destinations.create');
    }

    public function store(Request $request)
    {
        $destination       = new Pais();
        $destination->fill($request->all());
        $destination->save();
        return redirect()->route('destinations.index');
    }

    public function edit($id)
    {
        $destination  = Pais::find($id);
        return view('adm.destinations.edit', compact('destination'));
    }
    public function update(Request $request, $id)
    {
        $destination = Pais::find($id);
        $destination->fill($request->all());
        $destination->update();
        return redirect()->route('destinations.index');
    }
    public function destroy($id)
    {
        $destination = Pais::find($id);
        $destination->delete();
        return redirect()->route('destinations.index');
    }

    public function destroydes($id)
    {
        $destination = Pais::find($id);
        $destination->delete();
        return redirect()->route('destinations.index');
    }

    public function excel()
    {
        return view('adm.destinations.carga');
    }

    public function importexcel(Request $request)
    {
       // dd($request->excel);
        Excel::load($request->excel, function($reader) {
 
            foreach ($reader->get() as $book) {

                $pais = new Pais();
                $pais->pais=$book->pais;
                $pais->iata_pais=$book->iata_pais;
                $pais->save();

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
        return redirect()->route('destinations.index');

    }
    
}