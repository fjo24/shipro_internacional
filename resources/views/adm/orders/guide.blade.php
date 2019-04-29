@extends('adm.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
 <!-- page content -->
 <div class="right_col" role="main">
        <div class="">
          <div class="page-title hidden-print">
            <div class="title_left">
              <h3>Guia Internacional <small></small></h3>
            </div>
          </div>

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><b>Servicio: </b>{{$retiro->servicioShipro}} - <b>Tracking: </b>{{$retiro->trackingProveedor}}</h2> 
                    <h1 class="pull-right">{{$retiro->comprador->apellido_nombre}}</h1>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <section class="content invoice">
                    <!-- title row -->
                    <div class="row">
                      <div class="col-xs-12 invoice-header">
                        <h1>
                                <img src="{{asset('img/logo2.png')}}">
                                        <small class="pull-right">Date/Fecha: {{$retiro->fecha_hora}}</small>
                                    </h1>
                      </div>
                      <!-- /.col -->
                    </div>
                    <br>
                    <!-- info row -->
                    <div class="row invoice-info">
                      <div class="col-sm-4 invoice-col">
                        <h3><b>Remitente/Sender</b></h3>
                        <br>
                        <address>
                          <strong>{{$retiro->sender->empresa}}</strong>
                          <br>{{$retiro->sender->calle}} {{$retiro->sender->altura}} 
                          <br>Codigo postal: {{$retiro->sender->cp}}
                          <br>Pais de origen: {{$retiro->pais_origen}}
                        </address>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 invoice-col">
                        <h3><b>Destinatario/Addressee</b></h3>
                        <br>
                        <address>
                            <strong>{{$retiro->comprador->apellido_nombre}}</strong>
                            <br>Tel: {{$retiro->comprador->celular}}
                            <br>Email: {{$retiro->comprador->email}}
                            <br>Codigo postal: {{$retiro->comprador->cp}}
                            <br>Calle: {{$retiro->comprador->calle}} Altura: {{$retiro->comprador->altura}}
                            <br>Dpto:{{$retiro->comprador->dpto}} piso:{{$retiro->comprador->piso}}
                            <br>Localidad:{{$retiro->comprador->localidad}}
                            <br>Provincia:{{$retiro->comprador->provincia}}
                            <br>Pais: {{$retiro->pais_destino}}
                          </address>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 invoice-col">
                        @foreach ($retiro->productos as $producto)
                          <h3><b>Paquete/Pack</b></h3>
                          <br>
                          <b>Tipo de paquete/pack type: </b>
                          @if($retiro->forma_carga=01)
                          Carta
                          @else
                          Paquete
                          @endif
                          <br>
                          <b>Dimensiones/Dimensions: </b> 
                          <br><b>Largo/Large: </b>{{$producto->largo}} cm
                          <br><b>Ancho/Width: </b>{{$producto->ancho}} cm
                          <br><b>Alto/High: </b>{{$producto->alto}} cm
                          <br><b>Peso: </b>{{$producto->peso}} Kg
                        @endforeach
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </section>
                </div>
              </div>
              <div class="no-print">
                  <div class="text-center col-md-12 col-sm-12 no-padding no-print">
                      <button class="hidden-print btn btn-primary right" name="action" type="submit" onclick="window.print();">
                          Descargar PDF
                          <i class="glyphicon glyphicon-print"></i>
                      </button>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /page content -->
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('js/form.js')}}"></script>
    <script type="text/javascript">
        $('.printer').on('click', function () {
            window.print();
        });
    </script>
@endsection