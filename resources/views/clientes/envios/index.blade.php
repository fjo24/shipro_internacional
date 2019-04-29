@extends('clientes.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
{{-- <link rel="stylesheet" href="{{asset('web/assets/css/home.css')}}"> --}}
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Envios</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                </div>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Listado de envios</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Shipro Internacional
                    </p>
                    
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Destinatario</th>
                          <th>Proveedor</th>
                          <th>Tracking</th>
                          <th>Seguimiento</th>
                          <th>Estado</th>
                          <th>Servicio</th>
                          <th>Precio</th>
                          <th>Peso</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($retiros as $retiro)    
                        <tr>
                          <td>{{$retiro->fecha_hora}}</td>
                          <td>@isset($retiro->comprador->apellido_nombre)
                              {{$retiro->comprador->apellido_nombre}}
                              @endisset</td>
                          <td>{{$retiro->ProveedorShipro}}</td>
                          <td>{{$retiro->trackingProveedor}}</td>
                          <td>{{$retiro->seguimiento}}</td>
                          <td>{{$retiro->estado}}</td>
                          <td>{{$retiro->servicioShipro}}</td>
                          <td>{{$retiro->precio}}</td>
                          <td>{{$retiro->peso}} kg</td>
                          <td>
                              <a href='{{ route('envios.show', $retiro->id)}}'> 
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                              </a>
                              @if ($retiro->ProveedorShipro == 'UPS') 
                                        <a href="{{route('etiqueta_ups', $retiro->id)}}" target="_blank"> 
                                    <span class="glyphicon glyphicon-picture" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver etiqueta UPS"></span>
                                </a>
                                @elseif ($retiro->ProveedorShipro == 'FEDEX')  
                              <a href='{{ route('etiqueta_fedex', $retiro->id)}}'> 
                                    <span class="glyphicon glyphicon-picture" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver etiqueta FEDEX"></span>
                              </a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
@endsection
@section('js')
    <script type="text/javascript">

    </script>
@endsection        
