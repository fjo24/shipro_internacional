@extends('adm.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<div class="right_col" role="main">
    <div class="row">
        <div class="col-sm-12">
            {!!Form::open(['route'=>'estados.store', 'method'=>'POST', 'files' => true])!!}
            <div class="col-sm-12">
                    <div class="form-group col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Registrar estado</div>
                            <div class="panel-body">
                                <div class="form-group col-md-6">
                                    {!!Form::label('Nombre de estado:')!!}
                                    {!!Form::text('nombre', null , ['class'=>'input-medium', 'placeholder'=>'Nombre del estado', 'required'])!!}
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
                <div class="text-center col-md-12 col-sm-12 no-padding">
                    <button class="btn btn-primary right" name="action" type="submit">
                        Continuar y Guardar
                    </button>
                </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('js/form.js')}}"></script>
@endsection