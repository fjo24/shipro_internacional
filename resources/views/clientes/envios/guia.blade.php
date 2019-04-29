@extends('clientes.layouts.admin')

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
                  <h2><b>Proveedor: </b>{{$retiro->proveedorShipro}} </b><b> Servicio: </b>{{$retiro->servicioShipro}} - <b>Tracking: </b>{{$retiro->trackingProveedor}}</h2> 
                    <h1 class="pull-right">
                      @isset($retiro->comprador->apellido_nombre)
                      {{$retiro->comprador->apellido_nombre}}
                      @endisset
                    </h1>
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
                          <strong>{{$retiro->sucursal->descripcion}}</strong>
                          <br>{{$retiro->sucursal->calle}} {{$retiro->sucursal->altura}} 
                          <br>Codigo postal: {{$retiro->sucursal->cp}}
                          <br>Pais de origen: {{$retiro->sucursal->pais->pais}}
                        </address>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 invoice-col">
                        <h3><b>Destinatario/Addressee</b></h3>
                        <br>
                        <address>
                            <strong>@isset($retiro->comprador->apellido_nombre)
                                {{$retiro->comprador->apellido_nombre}}
                                @endisset</strong>
                            <br>Tel: 
                            @isset($retiro->comprador->celular)
                      {{$retiro->comprador->celular}}
                      @endisset
                            <br>Email: 
                            @isset($retiro->comprador->email)
                      {{$retiro->comprador->email}}
                      @endisset
                            <br>Codigo postal: 
                            @isset($retiro->comprador->cp)
                      {{$retiro->comprador->cp}}
                      @endisset
                    
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
                          <b>Tipo de paquete/pack type: </b>Muestra
                          <br>
                          <b>Dimensiones/Dimensions: </b> 
                          <br><b>Largo/Large: </b>{{$producto->largo}}
                          <br><b>Ancho/Width: </b>{{$producto->ancho}}
                          <br><b>Alto/High: </b>{{$producto->alto}}
                          <br><b>Peso: </b>{{$producto->peso}}
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
                    @if($retiro->proveedorShipro == "FEDEX")
                    <a href='{{ route('etiqueta_fedex', $retiro->id)}}'>
                      <button class="btn btn-primary right" name="action" type="submit">
                          Descargar etiqueta Fedex
                          <i class="glyphicon glyphicon-print"></i>
                      </button>
                    </a>
                    @elseif($retiro->proveedorShipro == "UPS")
                      <a href='{{ route('etiqueta_fedex', $retiro->id)}}'>
                      <button class="btn btn-primary right" name="action" type="submit">
                          Descargar etiqueta UPS
                          <i class="glyphicon glyphicon-print"></i>
                      </button>
                    </a>
                    @endif
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