@extends('clientes.layouts.admin') 
@section('title', 'Shipro Internacional') 
@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<div class="right_col" role="main">
    <div class="row">
        <div class="page-title hidden-print">
            <div class="title_left">
                <h3>Guia Internacional de exportación<small></small></h3>
            </div>
        </div>
        <div class="col-sm-12">
            @if(count($errors) > 0)
            <div class="alert alert-danger" role "alert">
                <h2>Por favor corrige los siguientes errores:</h2>
                    <ul>
                        @foreach($errors-> all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach	
                    </ul>	
                </div>
            @endif
            {!!Form::open(['route'=>'servicios', 'method'=>'POST', 'files' => true])!!}
            <div class="col-sm-4">
                <div class="form-group col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Remitente </div>
                        <div class="panel-body">
                            <span class="col-md-12">
                                {!!Form::label('Puede seleccionar un destinatario guardado', 'Puede seleccionar un destinatario guardado:')!!} 
                            </span>
                            <div class="form-group col-md-12">
                            <select class="form-control" id="sucursales" name="sucursales">
                                <option selected="selected" value="x">Seleccione sucursal</option>
                                @foreach ($sucursales as $sucursal)
                                    <option value="{{$sucursal->id}}">{{$sucursal->descripcion}}</option>
                                @endforeach
                            </select>
                            </div>
                            <span class="col-md-12">
                                {!!Form::label('Sucursal:')!!} 
                            </span>
                            
                            <div class="form-group col-md-12">
                                <input name="sucursal1" value="{{$sucursal->descripcion}}" type="text" class="form-control" disabled>
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <span class="col-md-12">
                                {!!Form::label('Email')!!} 
                            </span>
                            <span id="suc_email">
                                <div class="form-group col-md-12">
                                    <input value="{{$sucursal->mail}}" name="email" type="text" class="form-control" disabled>
                                    <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </span>
                            <span class="col-md-12">
                                {!!Form::label('Celular:')!!} 
                            </span>
                            <span id="suc_telephone">
                            <div class="form-group col-md-12">
                                <input name="telephone" value="{{$sucursal->celular}}" type="text" class="form-control" disabled>
                                <span class="fa fa-mobile-alt form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            </span>
                            <span class="col-md-12">
                                {!!Form::label('Numero de cuit:', 'Numero de cuit')!!} 
                            </span>
                            <span id="suc_numero_documento2">
                                <div class="form-group col-md-12">
                                    <input name="numero_documento2" value="{{$sucursal->cuit}}" type="text" class="form-control" placeholder="N° documento" disabled>
                                <span class="fa fa-id-card form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            </span>
                            <div class="form-group col-md-12">
                                {!!Form::label('Pais origen:', 'Pais de origen:')!!} {!! Form::select('pais_origen', $countries, $sucursal->pais->iata_pais, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                            </div>
                            <span class="col-md-12">
                                {!!Form::label('Provincia:')!!} 
                            </span>
                            <span id="suc_provincia">
                                <div class="form-group col-md-12">
                                    <input name="provincia" value="{{$sucursal->provincia}}" type="text" class="form-control" disabled>
                                    <span class="fa fa-map-marker-alt form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </span>
                            <span class="col-md-12">
                                {!!Form::label('Localidad:')!!} 
                            </span>
                            <span id="suc_localidad">
                                <div class="form-group col-md-12">
                                    <input name="localidad" value="{{$sucursal->localidad}}" type="text" class="form-control" disabled>
                                    <span class="fa fa-map-marker-alt form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </span>
                            <div class="form-group col-md-7">
                                <span class="col-md-12">
                                    {!!Form::label('Calle:')!!} 
                                </span>
                            <span id="suc_calle">
                                <div class="form-group col-md-12">
                                    <input name="calle" value="{{$sucursal->calle}}" type="text" class="form-control" disabled>
                                    <span class="" aria-hidden="true"></span>
                                </div>
                            </span>
                        </div>
                        <div class="form-group col-md-5">
                            <span class="col-md-12">
                                {!!Form::label('Altura:')!!} 
                            </span>
                            <span id="suc_altura">
                                <div class="form-group col-md-12">
                                    <input name="altura" value="{{$sucursal->altura}}" type="text" class="form-control" disabled>
                                    <span class="" aria-hidden="true"></span>
                                </div>
                            </span>
                        </div>
                        <div class="form-group col-md-4 no-padding">
                            <span class="col-md-12">
                                {!!Form::label('Piso:')!!} 
                            </span>
                            <span id="suc_piso">
                                <div class="form-group col-md-12">
                                    <input name="piso" value="{{$sucursal->piso}}" type="text" class="form-control" disabled>
                                    <span class="" aria-hidden="true"></span>
                                </div>
                            </span>
                        </div>
                        <div class="form-group col-md-4 no-padding">
                            <span class="col-md-12">
                                {!!Form::label('Dpto:')!!} 
                            </span>
                            <span id="suc_dpto">
                                <div class="col-md-12">
                                    <input name="dpto" value="{{$sucursal->dpto}}" type="text" class="form-control" disabled>
                                    <span class="" aria-hidden="true"></span>
                                </div>
                            </span>
                        </div>
                        <div class="form-group col-md-4 no-padding">
                            <span class="col-md-12">
                                {!!Form::label('Cp(*):')!!} 
                            </span>
                            <span id="suc_cp">
                                <div class="col-md-12">
                                    <input name="cp" value="{{$sucursal->cp}}" type="text" class="form-control" disabled>
                                    <span class="" aria-hidden="true"></span>
                                </div>
                            </span>
                            </div>
                            {{-- <span class="col-md-12">
                                {!!Form::label('Observación:')!!} 
                            </span>
                            <div class="col-md-12">
                                <input name="other_info" value="{{$sucursal->other_info}}" type="text" class="form-control" disabled>
                                <span class="fa fa-eye form-control-feedback right" aria-hidden="true"></span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group col-md-12">
                    <div class="panel panel-primary" id="crud">
                        <div class="panel-heading">Destinatario</div>
                        <div class="panel-body">
                            <span class="col-md-12">
                                {!!Form::label('Puede seleccionar un destinatario guardado', 'Puede seleccionar un destinatario guardado:')!!} 
                            </span>
                            <div class="form-group col-md-12">
                            <select class="form-control" id="destinatarios" name="destinatarios">
                                <option selected="selected" value="x">Seleccione destinatario</option>
                                @foreach ($destinatarios as $comprador)
                                    <option value="{{$comprador->id}}">{{$comprador->apellido_nombre}}</option>
                                @endforeach
                            </select>
                            </div>
                            <span class="col-md-12">
                                {!!Form::label('Nombre y Apellido:', 'Nombre y apellido:')!!} 
                            </span>
                            <span id="input_nombre_y_apellido">
                                <div class="form-group col-md-12">
                                    <input name="nombre_apellido2" value="{{ old('nombre_apellido2')}}" type="text" class="form-control" placeholder="Nombre y apellido">
                                    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </span>
                            <span class="col-md-12">
                                {!!Form::label('Email')!!} 
                            </span>
                            <span id="input_email">
                            <div class="form-group col-md-12">
                                <input name="email2" type="text" value="{{ old('email2')}}" class="form-control" placeholder="Correo Electronico">
                                <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            </span>
                            <span class="col-md-12">
                                {!!Form::label('Celular:')!!} 
                            </span>
                            <span id="input_telefono">
                            <div class="col-md-12">
                            <input name="telephone2" value="{{ old('telephone2')}}" type="text" class="form-control" placeholder="Telefono">
                                <span class="fa fa-mobile-alt form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            </span>
                            <div class="form-group col-md-4">
                                {!!Form::label('Tipo Doc:', 'Tipo doc:')!!}
                                {!! Form::select('tipo_documento_id', $tipo_docs, 2, ['class' => 'form-control', 'placeholder'
                                => 'Tipo']) !!}
                            </div>
                            <div class="form-group col-md-8">
                                <span class="col-md-12">
                                    {!!Form::label('Num Doc:', 'Num doc:')!!} 
                                </span>
                                <span id="input_documento">
                                <div class="form-group col-md-12">
                                    <input name="numero_documento" value="{{ old('numero_documento')}}" type="text" class="form-control" placeholder="N° documento">
                                    <span class="fa fa-id-card form-control-feedback right" aria-hidden="true"></span>
                                </div>
                                </span>
                            </div>
                            {{-- <div class="form-group col-md-12">
                                {!!Form::label('Pais destino:', 'Pais de destino:')!!} {!! Form::select('destination_id2', $countries2, null, ['class' => 'form-control', 'placeholder'
                                => 'Seleccione pais']) !!}
                            </div> --}}
                            {{-- <div class="col-md-12">
                                <h3>Destino</h3>
                                <div class="form-group">
                                    {{ Form::label('Pais destino', 'Seleccione la empresa') }}                    
                
                                    {{Form::select('pais',$countries2, null, ['class' => 'form-control selectpicker','id'=>'pais','placeholder'=>'Seleccionar pais'])}}           
                                </div>
                                <div class="form-group">
                                    {{ Form::label('provincias', 'Provincia') }}
                
                                    {{ Form::select('provincias',[],null, ['class' => 'form-control','id'=>'clasificaciones'])}}
                                </div>                                             
                            </div>       --}}      
                            <span id="input_pais">
                                <div class="form-group col-md-12">
                                    {{ Form::label('paises', 'Pais destino') }}                    
                                    {{Form::select('destination_id2',$countries2, null, ['class' => 'form-control selectpicker','id'=>'paises'])}}           
                                </div>
                            </span>
                            {{-- <div class="hidden form-group col-md-12">
                                {{ Form::label('provincias', 'Provincia') }}
                                {{ Form::select('codigo_provincia2',[],null, ['class' => 'form-control','id'=>'provincias'])}}
                            </div>  --}}                           
                            <span id="input_provincia">
                                <div class="form-group col-md-12">
                                    {{ Form::label('provincias', 'Provincia') }}
                                    <input value="{{ old('provincia2')}}" name="provincia2" id="provincia2" type="text" class="form-control" placeholder="Nombre de provincia">
                                </div>                            
                                <div class="hidden form-group col-md-12">
                                    {{ Form::label('provincias', 'Provincia') }}
                                    {{ Form::select('codigo_provincia2',[],null, ['class' => 'form-control','id'=>'provincia2'])}}
                                </div>                            
                            </span>
                            <span class="col-md-12">
                                {!!Form::label('Localidad:')!!} 
                            </span>
                            <span id="input_localidad">
                                <div class="form-group col-md-12">
                                    <input name="localidad2" value="{{ old('localidad2')}}" type="text" class="form-control" placeholder="">
                                    <span class="fa fa-map-marker-alt form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </span>
                            <div class="form-group col-md-7">
                                <span class="col-md-12">
                                    {!!Form::label('Calle:')!!} 
                                </span>
                                            <span id="input_calle">
                                    <div class="form-group col-md-12">
                                        <input name="calle2" value="{{ old('calle2')}}" type="text" class="form-control" placeholder="">
                                        <span class="" aria-hidden="true"></span>
                                    </div>
                                </span>
                                </div>
                            <div class="form-group col-md-5">
                                <span class="col-md-12">
                                    {!!Form::label('Altura:')!!} 
                                </span>
                            <span id="input_altura">
                                <div class="form-group col-md-12">
                                    <input name="altura2" value="{{ old('altura2')}}" type="text" class="form-control" placeholder="">
                                    <span class="" aria-hidden="true"></span>
                                </div>
                            </div>
                            </span>
                            <div class="form-group col-md-4 no-padding">
                                <span class="col-md-12">
                                    {!!Form::label('Piso:')!!} 
                                </span>
                            <span id="input_piso">
                                <div class="form-group col-md-12">
                                    <input name="piso2" value="{{ old('piso2')}}" type="text" class="form-control" placeholder="">
                                    <span class="" aria-hidden="true"></span>
                                </div>
                            </span>
                            </div>
                            <div class="form-group col-md-4 no-padding">
                                <span class="col-md-12">
                                    {!!Form::label('Dpto:')!!} 
                                </span>
                            <span id="input_dpto">
                                <div class="col-md-12">
                                    <input name="dpto2" value="{{ old('dpto2')}}" type="text" class="form-control" placeholder="">
                                    <span class="" aria-hidden="true"></span>
                                </div>
                            </span>
                            </div>
                            <div class="form-group col-md-4 no-padding">
                                <span class="col-md-12">
                                    {!!Form::label('Cp(*):')!!} 
                                </span>
                                <span id="input_cp">
                                    <div class="col-md-12">
                                        <input name="cp2" v-model="vcp2" value="{{ old('cp2')}}" type="text" class="form-control" placeholder="">
                                    </div>
                                </span>
                            </div>
                            <span class="col-md-12">
                                {!!Form::label('Observación:')!!} 
                            </span>
                            <span id="input_observacion">
                                <div class="col-md-12">
                                    <input name="other_info2" value="{{ old('other_info2')}}" type="text" class="form-control" placeholder="">
                                    <span class="fa fa-eye form-control-feedback right" aria-hidden="true"></span>
                                </div>
                            </span>
                            <br><br>
                            <div class="form-group col-md-12" style="margin-top: 25px;">
                            <span id="input_radio">
                                <p>
                                    <input type="radio" id="test1" name="to_do" value="nuevo">
                                    <label for="test1"> Guardar nuevo destinatario</label>
                                </p>
                                <p>
                                    <input type="radio" id="test2" name="to_do" value="actualizar">
                                    <label for="test2"> Actualizar destinatario</label>
                                </p>
                                <p>
                                    <input type="radio" id="test3" name="to_do"  value="no" checked>
                                    <label for="test3"> No guardar ni actualizar</label>
                                </p>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos del envio</div>
                        <div class="panel-body">
                            <div class="form-group col-md-12">
                                {!!Form::label('Documento o muestra:', 'Documento o muestra:')!!}
                                <!-- select dos opciones documento/muestra -->
                                {!! Form::select('tipo', ['01' => 'Carta', '02' => 'Paquete'], old('tipo'), ['class' => 'form-control', 'placeholder' => 'Seleccione
                                tipo de paquete']) !!}
                            </div>
                            <span class="col-md-12">
                                {!!Form::label('Fecha')!!} 
                            </span>
                            <div class="form-group col-md-12">
                                <input name="dateshow" value="{{$fecha}}" type="text" class="form-control" placeholder="" disabled>
                                <span class="fa fa-calendar-alt form-control-feedback right" aria-hidden="true"></span>
                            </div>
                            <div class="hidden form-group col-md-12">
                                {!!Form::label('Fecha:')!!} {!!Form::text('date', $fecha , ['class'=>'input-large', 'placeholder'=>'Fecha'])!!}
                            </div>
                            <div class="form-group col-md-12">
                                <div class="form-group col-md-6">
                                    {!!Form::label('Valor declarado:', 'Valor declarado:')!!}
                                </div>
                                <div class="form-group col-md-6">
                                    <input name="valor_declarado" type="text" value="{{ old('valor_declarado')}}" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group col-md-12 no-padding-left">
                                <div class="form-group col-md-2">
                                    {!!Form::label('Peso:')!!} 
                                </div>
                                <div class="form-group col-md-4">
                                    <input name="weight" value="{{ old('weight')}}" type="weight" id="weight" class="form-control" placeholder="kg" onchange="suma();" />
                                </div>
                                <div class="form-group col-md-6">
                                        {!!Form::label('Es fragil?:', 'Es frágil?:')!!} 
                                    <label>
                                        <input type="checkbox" value="{{ old('is_fragil')}}" name="is_fragil" class="js-switch" />
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12 no-padding-left">
                                <div class="form-group col-md-4 no-padding">
                                    <span class="col-md-12">
                                        {!!Form::label('Largo:')!!} 
                                    </span>
                                    <div class="form-group col-md-12">
                                        <input name="long" value="{{ old('long')}}" type="long" id="long" class="form-control" placeholder="cm" onchange="suma();" />
                                        <span class="" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 no-padding">
                                    <span class="col-md-12">
                                        {!!Form::label('Ancho:')!!} 
                                    </span>
                                    <div class="col-md-12">
                                        <input name="width" value="{{ old('width')}}" type="width" id="width" class="form-control" placeholder="cm" onchange="suma();" />
                                        <span class="" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 no-padding">
                                    <span class="col-md-12">
                                        {!!Form::label('Alto:')!!} 
                                    </span>
                                    <div class="col-md-12">
                                        <input name="height" value="{{ old('height')}}" type="height" id="height" class="form-control" placeholder="cm" onchange="suma();" />
                                        <span class="" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 no-padding-left">
                                <div class="form-group col-md-6">
                                    {!!Form::label('Peso volumetrico:', 'Peso volumetrico:')!!} 
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="col-md-12">
                                        {!!Form::text('volumetric_weight', old('volumetric_weight'), ['class'=>'form-control', 'placeholder'=>'', 'disabled' => 'true', 'id'=>'volumetric_weight'])!!}
                                        <span class="" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="form-group col-md-8">
                                        <span class="label_peso_a_calcular" style="font-size: 17px;font-weight: bold;">El peso aplicable al calculo: </span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <h3 class="peso_a_calcular text-left"><span class="label label-info" id="resultado">0</span></h3>
                                    </div>
                                    {!!Form::hidden('total', null , ['class'=>'input-large input-total', 'placeholder'=>'', 'disabled' => 'true', 'id'=>'total'])!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center col-md-12 col-sm-12 no-padding">
{{--                 <div id="main" class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <h1>Lista vue js - AJAX</h1>
                            <ul class="list-group">
                                <li v-for="item in lists" class="list-group-item">
                                    @{{ item }} 
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-8">
                            <h1>Lista vue js - AJAX</h1>
                            <pre>
                                @{{ $data | json }}
                            </pre>
                        </div>
                    </div>
                </div> --}}
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
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
                <script type="text/javascript" src="{{ asset('js/destinatarios.js')}}"></script> --}}
<script type="text/javascript" src="{{asset('js/form.js')}}"></script>
<script>
   /*  $('#pais').on('change', function(e){
        console.log(e);
        var pais_id = e.target.value;

        $.get('/ajax-provincia?pais_id=' + pais_id, function(data){
            //data:
            console.log(data);
        })
    })
 */
    $('#paises').on('change', function(e){
        console.log(e);
        var pais_id = e.target.value;
        $.get('/json-paises?codigo_pais=' + pais_id,function(data) {
            if (data == ""){
                $('#input_provincia').empty();
                $('#input_provincia').append('<span class="col-md-12"><label for="Provincia:">Provincia:</label></span><div class="form-group col-md-12" id="input_provincia"><input value="" name="provincia2" id="provincia2" type="text" class="form-control" placeholder="Nombre de provincia"></div>');
            }else{
                $('#input_provincia').empty();
                $('#input_provincia').append('<span class="col-md-12"><label for="Provincia:">Provincia:</label></span><div class="form-group col-md-12" id="input_provincia"><select class="form-control" id="cod_provincias2" name="codigo_provincia2"><option value="0" disable="true" selected="true">=== Seleccione provincia ===</option>');
                    
                    $.each(data, function(index, provinciasObj){
                        $('#cod_provincias2').append('<option value="'+ provinciasObj.codigo +'">'+ provinciasObj.descripcion +' / '+ provinciasObj.codigo +'</option></select></div>');
                    })
                }
            });
        });
        $('#destinatarios').on('change', function(e){
        console.log(e);
        var destinatario_id = e.target.value;
        $.get('/json-destinatarios?id=' + destinatario_id,function(data) {
            console.log(data);
            if (destinatario_id == "x"){
                $('#input_nombre_y_apellido').empty();
                $('#input_nombre_y_apellido').append('<div class="form-group col-md-12"><input name="nombre_apellido2" type="text" class="form-control" value=""  placeholder="Nombre y apellido"><span class="fa fa-user form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_email').empty();
                $('#input_email').append('<div class="form-group col-md-12"><input name="email2" type="text" class="form-control" value="" placeholder="Correo Electronico"><span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_telefono').empty();
                $('#input_telefono').append('<div class="form-group col-md-12"><input name="telephone2" type="text" class="form-control" value="" placeholder="Telefono"><span class="fa fa-mobile-alt form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_documento').empty();
                $('#input_documento').append('<div class="form-group col-md-12"><input name="numero_documento2" type="text" class="form-control" value="" placeholder="Num de doc"><span class="fa fa-id-card form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_localidad').empty();
                $('#input_localidad').append('<div class="form-group col-md-12"><input name="localidad2" type="text" class="form-control" value="" placeholder="Localidad"><span class="fa fa-map-marker-alt form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_calle').empty();
                $('#input_calle').append('<div class="form-group col-md-12"><input name="calle2" type="text" class="form-control" value="" placeholder="calle"></div>');                        
                $('#input_altura').empty();
                $('#input_altura').append('<div class="form-group col-md-12"><input name="altura2" type="text" class="form-control" value="" placeholder="Altura"></div>');
                $('#input_piso').empty();
                $('#input_piso').append('<div class="form-group col-md-12"><input name="piso2" type="text" class="form-control" value="" placeholder="piso"></div>');
                $('#input_dpto').empty();
                $('#input_dpto').append('<div class="form-group col-md-12"><input name="dpto2" type="text" class="form-control" value="" placeholder="Num dpto"></div>');
                $('#input_cp').empty();
                $('#input_cp').append('<div class="form-group col-md-12"><input name="cp2" type="text" class="form-control" value="" placeholder="Codigo postal"></div>');
                $('#input_observacion').empty();
                $('#input_observacion').append('<div class="form-group col-md-12"><input name="other_info2" type="text" class="form-control" value="" placeholder="Informacion adicional"><span class="fa fa-eye form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_radio').empty();
                $('#input_radio').append('<p><input type="radio" id="test1" name="to_do" value="nuevo"><label for="test1"> Guardar nuevo destinatario</label></p><p><input type="radio" id="test2" name="to_do" value="actualizar" disabled><label for="test2"> Actualizar destinatario</label></p><p><input type="radio" id="test3" name="to_do"  value="no" checked><label for="test3"> No guardar ni actualizar</label></p>');
            }else{
                $('#input_nombre_y_apellido').empty();
                $('#input_nombre_y_apellido').append('<div class="form-group col-md-12"><input name="nombre_apellido2" type="text" class="form-control" value="'+data.destinatario.apellido_nombre+'"  placeholder="Nombre y apellido"><span class="fa fa-user form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_email').empty();
                $('#input_email').append('<div class="form-group col-md-12"><input name="email2" type="text" class="form-control" value="'+data.destinatario.email+'" placeholder="Correo Electronico"><span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_telefono').empty();
                $('#input_telefono').append('<div class="form-group col-md-12"><input name="telephone2" type="text" class="form-control" value="'+data.destinatario.celular+'" placeholder="Telefono"><span class="fa fa-mobile-alt form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_documento').empty();
                $('#input_documento').append('<div class="form-group col-md-12"><input name="numero_documento2" type="text" class="form-control" value="'+data.destinatario.numero_documento+'" placeholder="Num de doc"><span class="fa fa-id-card form-control-feedback right" aria-hidden="true"></span></div>');
                $('#input_radio').empty();
                $('#input_radio').append('<p><input type="radio" id="test1" name="to_do" value="nuevo" disabled><label for="test1"> Guardar nuevo destinatario</label></p><p><input type="radio" id="test2" name="to_do" value="actualizar"><label for="test2"> Actualizar destinatario</label></p><p><input type="radio" id="test3" name="to_do"  value="no" checked><label for="test3"> No guardar ni actualizar</label></p>');
                if (data.destinatario.localidad != null){                        
                    $('#input_localidad').empty();
                    $('#input_localidad').append('<div class="form-group col-md-12"><input name="localidad2" type="text" class="form-control" value="'+data.destinatario.localidad+'" placeholder="Localidad"><span class="fa fa-map-marker-alt form-control-feedback right" aria-hidden="true"></span></div>');
                }
                if (data.destinatario.calle != null){                        
                    $('#input_calle').empty();
                    $('#input_calle').append('<div class="form-group col-md-12"><input name="calle2" type="text" class="form-control" value="'+data.destinatario.calle+'" placeholder="calle"></div>');
                }
                if (data.destinatario.altura != null){                        
                    $('#input_altura').empty();
                    $('#input_altura').append('<div class="form-group col-md-12"><input name="altura2" type="text" class="form-control" value="'+data.destinatario.altura+'" placeholder="Altura"></div>');
                }
                if (data.destinatario.piso != null){                        
                    $('#input_piso').empty();
                    $('#input_piso').append('<div class="form-group col-md-12"><input name="piso2" type="text" class="form-control" value="'+data.destinatario.piso+'" placeholder="piso"></div>');
                }
                if (data.destinatario.dpto != null){                        
                    $('#input_dpto').empty();
                    $('#input_dpto').append('<div class="form-group col-md-12"><input name="dpto2" type="text" class="form-control" value="'+data.destinatario.dpto+'" placeholder="Num dpto"></div>');
                }
                if (data.destinatario.cp != null){                        
                    $('#input_cp').empty();
                    $('#input_cp').append('<div class="form-group col-md-12"><input name="cp2" type="text" class="form-control" value="'+data.destinatario.cp+'" placeholder="Codigo postal"></div>');
                }
                if (data.destinatario.other_info != null){                        
                    $('#input_observacion').empty();
                    $('#input_observacion').append('<div class="form-group col-md-12"><input name="other_info2" type="text" class="form-control" value="'+data.destinatario.other_info+'" placeholder="Informacion adicional"><span class="fa fa-eye form-control-feedback right" aria-hidden="true"></span></div>');
                }
                $('#paises').empty();
                provincia_id_destinatario = data.destinatario.provincia_id;
                pais_id_destinatario = data.destinatario.pais_id;
                paises_dest = data.paises;
                $('#paises').append('<select class="form-control" name="destination_id2">');
                    $.each(paises_dest, function(index, paisObj){
                        if (pais_id_destinatario == paisObj.id){
                            $('#paises').append('<option selected="selected" value="'+ paisObj.id +'">'+ paisObj.pais +'</option></div>');
                        }else{
                            $('#paises').append('<option value="'+ paisObj.id +'">'+ paisObj.pais +'</option></select></div>');
                        }
                    });
                    var pais_id = data.destinatario.pais_id;
                    var provincia = data.destinatario.provincia_id;
                    var nprovincia = data.destinatario.provincia;
                    
                    $.get('/json-paises?codigo_pais=' + pais_id,function(data) {
                        if (data == ""){                        
                            $('#input_provincia').empty();
                            $('#input_provincia').append('<span class="col-md-12"><label for="Provincia:">Provincia:</label></span><div class="form-group col-md-12" id="input_provincia"><input value="'+nprovincia+'" name="provincia2" id="provincia2" type="text" class="form-control" placeholder="Nombre de provincia"></div>');
                        }else{
                            $('#input_provincia').empty();
                            $('#input_provincia').append('<span class="col-md-12"><label for="Provincia:">Provincia:</label></span><div class="form-group col-md-12" id="input_provincia"><select class="form-control" id="cod_provincias2" name="codigo_provincia2"><option value="0" disable="true" selected="true">=== Seleccione provincia ===</option>');
                                
                                $.each(data, function(index, provinciasObj){
                                    if (provincia == provinciasObj.id){
                                        $('#cod_provincias2').append('<option selected="selected" value="'+ provinciasObj.codigo +'">'+ provinciasObj.descripcion +' / '+ provinciasObj.codigo +'</option></select></div>');
                                    }else{
                                        $('#cod_provincias2').append('<option value="'+ provinciasObj.codigo +'">'+ provinciasObj.descripcion +' / '+ provinciasObj.codigo +'</option></select></div>');
                                    }
                                })
                            }
                        });
                    }
                });
                
            });
            $('#sucursales').on('change', function(e){
                console.log(e);
                var pais_id = e.target.value;
                $.get('/json-sucursales?id=' + pais_id,function(data) {
                    if (data == ""){
                    }else{
                        console.log(data);
                        $('#suc_email').empty();
                        $('#suc_email').append('<div class="form-group col-md-12"><input value="'+data.mail+'" name="email" type="text" class="form-control" disabled><span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span></div>');
                        $('#suc_telephone').empty();
                        $('#suc_telephone').append('<div class="form-group col-md-12"><input name="telephone" value="'+data.celular+'" type="text" class="form-control" disabled><span class="fa fa-mobile-alt form-control-feedback right" aria-hidden="true"></span></div>');
                        $('#suc_numero_documento2').empty();
                        $('#suc_numero_documento2').append('<div class="form-group col-md-12"><input name="numero_documento2" value="'+data.cuit+'" type="text" class="form-control" placeholder="N° documento" disabled><span class="fa fa-id-card form-control-feedback right" aria-hidden="true"></span></div>');
                        $('#suc_provincia').empty();
                        $('#suc_provincia').append('<div class="form-group col-md-12"><input name="provincia" value="'+data.provincia+'" type="text" class="form-control" disabled><span class="fa fa-map-marker-alt form-control-feedback right" aria-hidden="true"></span></div>');
                        $('#suc_localidad').empty();
                        $('#suc_localidad').append('<div class="form-group col-md-12"><input name="localidad" value="'+data.localidad+'" type="text" class="form-control" disabled><span class="fa fa-map-marker-alt form-control-feedback right" aria-hidden="true"></span></div>');
                        $('#suc_calle').empty();
                        $('#suc_calle').append('<div class="form-group col-md-12"><input name="calle" value="'+data.calle+'" type="text" class="form-control" disabled><span class="" aria-hidden="true"></span></div>');
                        $('#suc_altura').empty();
                        $('#suc_altura').append('<div class="form-group col-md-12"><input name="altura" value="'+data.altura+'" type="text" class="form-control" disabled><span class="" aria-hidden="true"></span></div>');
                        $('#suc_piso').empty();
                        $('#suc_piso').append('<div class="form-group col-md-12"><input name="piso" value="'+data.piso+'" type="text" class="form-control" disabled>');
                        $('#suc_dpto').empty();
                        $('#suc_dpto').append('<div class="col-md-12"><input name="dpto" value="'+data.dpto+'" type="text" class="form-control" disabled><span class="" aria-hidden="true"></span></div>');
                        $('#suc_cp').empty();
                        $('#suc_cp').append('<div class="col-md-12"><input name="cp" value="'+data.cp+'" type="text" class="form-control" disabled><span class="" aria-hidden="true"></span></div>');
                        }
                    });
                });

                </script>
                
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script type="text/javascript">
    var urlUser = 'https://jsonplaceholder.typicode.com/users';
    new Vue({
        el: '#crud',
        data:{
            vcp2: '',
            errors:[]
        },
        methods:{
            createship: function(){
                var url = 'servicios'
                axios.post(url, {
                    cp2: this.vcp2
                }).then(response => {
                    this.errors = [];
                }).catch(error=>{
                    this.errors = error.response.data
                });
            }
        }
    });
</script> --}}
@endsection