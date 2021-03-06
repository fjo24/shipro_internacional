@extends('clientes.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<div class="right_col" role="main">
    <div class="row">
        <div class="col-sm-12">
            {!!Form::open(['route'=>'destinatarios.store', 'method'=>'POST', 'files' => true])!!}
                        <div class="panel panel-info">
                            <div class="panel-heading">Registrar destinatario</div>
                            <div class="panel-body">
                                <div class="form-group col-md-12">
                                <div class="form-group col-md-4">
                                    {!!Form::label('Nombre y apellido:')!!}
                                    <input name="apellido_nombre" type="text" value="{{ old('apellido_nombre')}}" class="form-control" placeholder="Nombre y apellido">
                                </div>
                                <div class="form-group col-md-4">
                                    {!!Form::label('Numero de cuit:')!!}
                                    <input name="cuit" type="text" value="{{ old('cuit')}}" class="form-control" placeholder="Cuit">
                                </div>
                                <div class="form-group col-md-4">
                                    {!!Form::label('Numero de telefono:')!!}
                                    <input name="celular" type="text" value="{{ old('celular')}}" class="form-control" placeholder="Numero de telefono">
                                </div> 
                            </div>
                                <div class="form-group col-md-12">
                                <div class="form-group col-md-3">
                                    {{ Form::label('paises', 'Pais') }}                    
                                    {{Form::select('pais_id',$paises, null, ['class' => 'form-control','id'=>'paises'])}}
                                </div>
                                <span id="input_provincia" class="form-group col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('provincias', 'Provincia') }}
                                        <input name="provincia" type="text" value="{{ old('provincia_id')}}" class="form-control" placeholder="Provincia o estado">
                                    </div>                    
                                    <div class="hidden form-group col-md-12">
                                        {{ Form::label('provincias', 'Provincia') }}
                                        {{ Form::select('provincia_id',[],null, ['class' => 'form-control','id'=>'cod_provincias2'])}}
                                    </div>                                      
                                </span>
                                <div class="form-group col-md-3">
                                    {!!Form::label('Localidad:')!!}
                                    <input name="localidad" type="text" value="{{ old('localidad')}}" class="form-control" placeholder="Localidad">
                                </div>
                                <div class="form-group col-md-3">
                                    {!!Form::label('Codigo Postal:')!!}
                                    <input name="cp" type="text" value="{{ old('cp')}}" class="form-control" placeholder="Codigo postal">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="form-group col-md-3">
                                    {!!Form::label('Calle:')!!}
                                    <input name="calle" type="text" value="{{ old('calle')}}" class="form-control" placeholder="Nombre de la calle">
                                </div>
                                <div class="form-group col-md-3">
                                    {!!Form::label('Altura:')!!}
                                    {!!Form::text('altura', old('altura') , ['class'=>'form-control', 'placeholder'=>'Altura'])!!}
                                </div>
                                <div class="form-group col-md-3">
                                    {!!Form::label('Piso:')!!}
                                    {!!Form::text('piso', old('piso') , ['class'=>'form-control', 'placeholder'=>'piso'])!!}
                                </div>
                                <div class="form-group col-md-3">
                                    {!!Form::label('Departamento:')!!}
                                    {!!Form::text('dpto', old('dpto') , ['class'=>'form-control', 'placeholder'=>'Numero de departamento'])!!}
                                </div>
                            </div>
                            <div class="text-center col-md-12 col-sm-12 no-padding">
                                <button class="btn btn-primary right" name="action" type="submit">
                                    Continuar y Guardar
                                </button>
                            </div>
                            </div>
                        </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('js/form.js')}}"></script>
    <script>
    $('#paises').on('change', function(e){
        console.log(e);
        var pais_id = e.target.value;
        $.get('/json-paises?codigo_pais=' + pais_id,function(data) {
            console.log(pais_id);
            if (data == ""){
                console.log("llega al if");
                $('#input_provincia').empty();
                $('#input_provincia').append('<label for="Provincia:">Provincia:</label><div class="form-group" id="input_provincia"><input value="" name="provincia" id="provincia2" type="text" class="form-control" placeholder="Provincia o estado"></div>');
            }else{console.log(data);
                $('#input_provincia').empty();
                $('#input_provincia').append('<label for="Provincia:">Provincia:</label><div class="form-group" id="input_provincia"><select class="form-control" id="cod_provincias2" name="provincia_id"><option value="0" disable="true" selected="true">=== Seleccione provincia ===</option>');

                $.each(data, function(index, provinciasObj){
                $('#cod_provincias2').append('<option value="'+ provinciasObj.codigo +'">'+ provinciasObj.descripcion +' / '+ provinciasObj.codigo +'</option></select></div>');
                })
             }
        });
      });
  </script>
@endsection