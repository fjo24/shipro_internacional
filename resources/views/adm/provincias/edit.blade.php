@extends('adm.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<div class="right_col" role="main">
    <div class="row">
        <div class="col-sm-12">
            {!!Form::model($provincia, ['route'=>['provincias.update',$provincia->id], 'method'=>'PUT', 'files' => true])!!}
            <div class="col-sm-12">
                <div class="form-group col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Editar provincia</div>
                        <div class="panel-body">
                            <div class="form-group col-md-4">
                                {!!Form::label('Pais:')!!}
                                {!! Form::select('pais_id', $paises, null, ['class' => 'form-control', 'placeholder'
                                    => 'Seleccione pais']) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!!Form::label('Descripción:')!!}
                                {!!Form::text('descripcion', null , ['class'=>'input-medium', 'placeholder'=>'Nombre de provincia', 'required'])!!}
                            </div>
                            <div class="form-group col-md-4">
                                {!!Form::label('Codigo:')!!}
                                {!!Form::text('codigo', null , ['class'=>'input-medium', 'placeholder'=>'Codigo de la provincia', 'required'])!!}
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