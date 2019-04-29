@extends('adm.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<div class="right_col" role="main">
    <div class="row">
        <div class="col-sm-12">
            {!!Form::open(['route'=>'destinations.store', 'method'=>'POST', 'files' => true])!!}
            <div class="col-sm-6">
                    <div class="form-group col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Registrar destino</div>
                            <div class="panel-body">
                                <div class="form-group col-md-4">
                                    {!!Form::label('Pais:')!!}
                                    {!!Form::text('country', null , ['class'=>'input-medium', 'placeholder'=>'Pais', 'required'])!!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!!Form::label('Ciudad:')!!}
                                    {!!Form::text('city', null , ['class'=>'input-medium', 'placeholder'=>'Ciudad', 'required'])!!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!!Form::label('Grupo:')!!}
                                    {!!Form::text('group', null , ['class'=>'input-medium', 'placeholder'=>'Grupo', 'required'])!!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!!Form::label('Codigo:')!!}
                                    {!!Form::text('code', null , ['class'=>'input-medium', 'placeholder'=>'Codigo', 'required'])!!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!!Form::label('Aeropuerto:')!!}
                                    {!!Form::text('airport', null , ['class'=>'input-medium', 'placeholder'=>'Aeropuerto', 'required'])!!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!!Form::label('Codigo maria:')!!}
                                    {!!Form::text('maria_code', null , ['class'=>'input-medium', 'placeholder'=>'Aeropuerto', 'required'])!!}
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