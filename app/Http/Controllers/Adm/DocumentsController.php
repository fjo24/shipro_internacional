<?php

namespace App\Http\Controllers\Adm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tipo_documento;

class DocumentsController extends Controller
{
    public function index()
    {
        $types=Tipo_documento::OrderBy('id', 'ASC')->get();
        return view('adm.documents.index', compact('types'));
    }

    public function create()
    {
        return view('adm.documents.create');
    }

    public function store(Request $request)
    {
        $type       = new Tipo_documento();
        $type->nombre = $request->nombre;
        $type->save();
        return redirect()->route('documents.index');
    }

    public function edit($id)
    {
        $type  = Tipo_documento::find($id);
        return view('adm.documents.edit', compact('type'));
    }
    public function update(Request $request, $id)
    {
        $type = Tipo_documento::find($id);
        $type->fill($request->all());
        $type->update();
        return redirect()->route('documents.index');
    }
    public function destroy($id)
    {
        $type = Tipo_documento::find($id);
        $type->delete();
        return redirect()->route('documents.index');
    }

    public function destroydoc($id)
    {
        $type = Tipo_documento::find($id);
        $type->delete();
        return redirect()->route('documents.index');
    }
}
