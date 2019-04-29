@extends('clientes.layouts.admin') 
@section('title', 'Shipro Internacional') 
@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title hidden-print">
      <div class="title_left">
        <h3>Servicios Disponibles.. <small></small></h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          @if ($array_ups!=null||$arrayfedex!=null)
          <div class="x_title">
            <h2>Proveedores y servicios <small></small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="table-responsive">
              <table id="tabla" class="table table-striped jambo_table bulk_action">
                <thead>
                  <tr class="headings">
                    <th class="column-title">Proveedor </th>
                    <th class="column-title">Servicio </th>
                    <th class="column-title">Precio </th>
                    <th class="column-title">Fecha estimada </th>
                    <th class="column-title">Acción</th>
                    </th>
                    <th class="bulk-actions" colspan="7">
                      <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {{-- DATOS EN TABLA PARA UPS --}} 
                  @isset($array_ups) 
                  {{-- @foreach ($array_ups as $currier) --}}
                  <tr class="even pointer">
                    <td class=" "><img class="logo_proveedor" src="{{asset('img/curriers/logo_ups.png')}}" alt="..." width="35" height="35"></td>
                    <td class=" ">{{$array_ups['servicion']}}</td>
                    <div><input type="hidden" value="{{$array_ups['servicion']}}" name="id"></div>
                    <td class=" "><i class="success fa fa-dollar"></i>{{$array_ups['precio']}} (USD)</td>
                    <td class=" "> - </td>
                    <td class=" "><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modalcurrier{{$array_ups['id']}}">Comprar</button></td>
                  </tr>
                  {!! Form::open(['route' => 'mercadopago', 'method' => 'POST']) !!}
                  <!-- Small modal -->
                  <div class="modal fade modalcurrier{{$array_ups['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
                          <h4 class="modal-title" id="myModalLabel2"><img class="logo_proveedor" src="{{asset('img/curriers/logo_ups.png')}}" alt="..." width="35" height="35">&nbsp&nbsp{{$array_ups['proveedor']}}</h4>
                        </div>
                        <div class="modal-body">
                          <h2>Servicio: {{$array_ups['servicion']}}</h2>
                          <h1>${{$array_ups['precio']}} (USD)</h1>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-primary">Confirmar compra</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /modals -->
                  <div class="hidden">
                    <div class="form-group col-md-12">
                      {!!Form::text('idserv', $array_ups['id'], ['class'=>'input-large', 'placeholder'=>'Apellidos y nombre'])!!} {!!Form::text('descripcion',
                      $array_ups['servicion'], ['class'=>'input-large', 'placeholder'=>'Apellidos y nombre'])!!} {!!Form::text('proveedor',
                      $array_ups['proveedor'], ['class'=>'input-large', 'placeholder'=>'Apellidos y nombre'])!!}
                    </div>
                    <div class="form-group col-md-12">
                      {!!Form::label('Precio:')!!} {!!Form::text('precio', $array_ups['precio'], ['class'=>'input-large', 'placeholder'=>''])!!}
                    </div>
                  </div>
                  {!!Form::close()!!} {{-- @endforeach --}} 
                  @endisset 
                  {{-- FIN DATOS EN TABLA PARA UPS --}} 
                  {{-- DATOS EN TABLA PARA FEDEX --}} 
                  @if(isset($arrayfedex['RateReplyDetails']) && ($arrayfedex['HighestSeverity'] != 'FAILURE') && ($arrayfedex['HighestSeverity']
                  != 'ERROR')) 
                  @foreach ($arrayfedex['RateReplyDetails'] as $currier) 
                  @if ($currier['ServiceType']=='INTERNATIONAL_PRIORITY'
                  || $currier['ServiceType']=='INTERNATIONAL_ECONOMY')
                  <tr class="even pointer">
                    <td class=" "><img class="logo_proveedor" src="{{asset('img/curriers/logo_fedex.png')}}" alt="..." width="50" height="20"></td>
                    <td class=" ">{{$currier['ServiceType']}}</td>
                    <div><input type="hidden" value="{{$currier['ServiceType']}}" name="id"></div>
                    <td class=" "><i class="success fa fa-dollar"></i>{{$currier['RatedShipmentDetails']['ShipmentRateDetail']['TotalNetCharge']['Amount']}}
                      (USD)</td>
                    <td class=" ">
                      @if (isset($currier['DeliveryTimestamp'])) {{$currier['DeliveryTimestamp']}} @endif
                    </td>
                    <td class=" "><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modalfedex{{$currier['ServiceType']}}">Comprar</button></td>
                  </tr>
                  {!! Form::open(['route' => 'mercadopago', 'method' => 'POST']) !!}
                  <!-- Small modal -->
                  <div class="modal fade modalfedex{{$currier['ServiceType']}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2"><img class="logo_proveedor" src="{{asset('img/curriers/logo_fedex.png')}}" alt="..." width="50"
                              height="20"></h4>
                        </div>
                        <div class="modal-body">
                          <h2>Servicio: {{$currier['ServiceType']}}</h2>
                          <h1>${{$currier['RatedShipmentDetails']['ShipmentRateDetail']['TotalNetCharge']['Amount']}} (USD)</h1>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-primary">Confirmar compra</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /modals -->
                  <div class="hidden">
                    <div class="form-group col-md-12">
                      {!!Form::text('idserv', $currier['ServiceType'], ['class'=>'input-large', 'placeholder'=>'Apellidos y nombre'])!!} {!!Form::text('descripcion',
                      $currier['ServiceType'], ['class'=>'input-large', 'placeholder'=>'Apellidos y nombre'])!!} {!!Form::text('proveedor',
                      'FEDEX', ['class'=>'input-large', 'placeholder'=>'Apellidos y nombre'])!!}
                    </div>
                    <div class="form-group col-md-12">
                      {!!Form::label('Precio:')!!} {!!Form::text('precio', $currier['RatedShipmentDetails']['ShipmentRateDetail']['TotalNetCharge']['Amount'],
                      ['class'=>'input-large', 'placeholder'=>''])!!}
                    </div>
                  </div>
            </div>
            {!!Form::close()!!} @endif @endforeach @else
            <tr class="even pointer">
              <td class=" "><img class="logo_proveedor" src="{{asset('img/curriers/logo_fedex.png')}}" alt="..." width="50" height="20"></td>
              <td class=" ">Temporalmente no disponible</td>
              <td class=" "></td>
              <td class=" ">
              </td>
              <td class=" "></td>
            </tr>
            @endif {{-- FIN DATOS EN TABLA PARA FEDEX --}}
            </tbody>
            </table>
          </div>
        </div>
        @else
        <div class="media">
          <div class="media-left">
            <a href="#">
                <img class="media-object" src="{{asset('img/curriers/logo_null.png')}}" alt="..." width="100" height="100">
              </a>
          </div>
          <div class="media-body">
            <h4 class="media-heading">Atención!</h4>
            <div class="servicio_no_disponible">Servicio no disponible para la ruta seleccionada!</div>
            <a href="{{ URL::previous() }}">
                  <button class="btn btn-warning pull-right btn-lg" name="action" type="submit">
                    <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                    Volver
                  </button>
                      </a>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
</div>
<!-- /page content -->
@endsection
@section('js')
<script type="text/javascript" src="{{asset('js/form.js')}}"></script>
@endsection