@extends('clientes.layouts.admin') 
@section('title', 'Shipro Internacional') 
@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<!-- page content -->
<div class="right_col" role="main">
    <div class="page-title hidden-print">
      <div class="title_left">
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title">Datos de envio</h3>
                </div>
                <div class="panel-body">
                  <div class="col-md-8">
                    <table class="table-striped" style="width:100%">
                        <tr>
                          <th>Destinatario:</th>
                          <td>{{$data['destinatario']['destinatario']}}</td>
                        </tr>
                        <tr>
                          <th>Codigo postal:</th>
                          <td>{{$data['destinatario']['cp']}}</td>
                        </tr>
                        <tr>
                          <th>Email:</th>
                          <td>{{$data['destinatario']['email']}}</td>
                        </tr>
                        <tr>
                          <th>Proveedor:</th>
                          <td>{{$data['servicio']['proveedor']}}</td>
                        </tr>
                        <tr>
                          <th>Tipo de servicio:</th>
                          <td>{{$data['servicio']['id']}}</td>
                        </tr>
                        <tr>
                          <th>Costo:</th>
                          <td>{{$data['servicio']['precio']}}</td>
                        </tr>
                      </table>
                  </div>
                  <div class="col-md-2">
                    <img style="" src="{{asset('img/logo_mercadopago.png')}}" class="img-responsive" alt="Responsive image">
                  </div>
                  <div class="col-md-2">
                    <a href="{{$data['mercadopago']['confirmacion_url']}}">
                      <button type="button" class="btn btn-primary active">Confirmar y pagar</button>
                    </a>
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
@endsection