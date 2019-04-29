@extends('adm.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<div class="right_col" role="main">
    <div class="row">
        <div class="col-sm-12"> 
            {!!Form::open(['route'=>'cpcordones.store', 'method'=>'POST', 'files' => true])!!}
            <div class="col-sm-12">
                    <div class="form-group col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Registrar cordon de codigo postal</div>
                            <div class="panel-body">
                                <div class="form-group col-md-6">
                                    {!!Form::label('Zona:')!!}
                                    {!! Form::select('cordon_id', $cps, null, ['class' => 'form-control', 'placeholder'
                                        => 'Seleccione cordon']) !!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!!Form::label('Codigo postal:')!!}
                                    {!!Form::text('cp', null , ['class'=>'form-control', 'placeholder'=>'Codigo postal', 'required'])!!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!!Form::label('Localidad:')!!}
                                    {!!Form::text('localidad', null , ['class'=>'form-control', 'placeholder'=>'Localidad', 'required'])!!}
                                </div>
                                <div class="form-group col-md-6">
                                    {!!Form::label('Provincia:')!!}
                                    {!!Form::text('provincia', null , ['class'=>'form-control', 'placeholder'=>'Provincia', 'required'])!!}
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