@extends('adm.layouts.admin') 
@section('title', 'Shipro Internacional') 
@section('content')
<link rel="stylesheet" href="{{asset('css/style.css')}}">
{{-- <script src="{{asset('css/bootstrap.css')}}"></script>
 --}}
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
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Busqueda</button>
                        </ul>
                        <!-- Trigger the modal with a button -->
                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog estilo_modal">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Filtro personalizado</h4>
                                    </div>
                                    <div class="modal-body" style="height: 200px;">
                                        <div class="form-group col-md-12">
                                            {{ Form::open(['route' => 'ordenes', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                    {!!Form::label('Por currier:')!!} {!!Form::text('currier', null ,['class'=>'input-large'])!!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                    {!!Form::label('Por tracking:')!!} {!!Form::text('tracking', null ,['class'=>'input-large'])!!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                    {!!Form::label('Por destinatario:')!!} {!!Form::text('destinatario', null ,['class'=>'input-large'])!!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                    {!!Form::label('Por servicio:')!!} {!!Form::text('servicio', null ,['class'=>'input-large'])!!}
                                                </div>
                                            </div>
                                            <div class="form-group date col-md-3">
                                                <div class="form-group">
                                                    {!!Form::label('Desde Fecha:')!!} {!!Form::text('fechamenor', null ,['class'=>'input-large calendario'])!!}
                                                </div>
                                            </div>
                                            <div class="form-group date col-md-3">
                                                <div class="form-group">
                                                    {!!Form::label('Hasta fecha:')!!} {!!Form::text('fechamayor', null ,['class'=>'input-large calendario'])!!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                    {!!Form::label('Por estado:')!!} {!!Form::text('estado', null ,['class'=>'input-large'])!!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <div class="form-group">
                                                    {!!Form::label('Por estado shipro:')!!} {!! Form::select('estado_id', $estados, null, ['class' => 'input-large', 'placeholder'
                                                    => 'Seleccione']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12" style="text-align: center;">
                                                <div class="form-group" style="padding-top: 3%;">
                                                    {!!Form::label('')!!}
                                                    <button class="btn btn-lg btn-info" type="submit">Buscar
                                                </button>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                            Shipro Internacional
                        </p>
                        <table class="table table-striped " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Destinatario</th>
                                    <th>Currier</th>
                                    <th>Tracking</th>
                                    <th>Estado</th>
                                    <th>Estado Shipro</th>
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
                                    <td>@isset($retiro->comprador->apellido_nombre) {{$retiro->comprador->apellido_nombre}} @endisset
                                    </td>
                                    <td>{{$retiro->ProveedorShipro}}</td>
                                    <td>{{$retiro->trackingProveedor}}</td>
                                    <td>{{$retiro->estado}}</td>
                                    <td data-toggle="modal" data-target="#modalestado{{$retiro->id}}">
                                        <label data-toggle="tooltip" data-placement="top" style="cursor:pointer" title="Editar estado">
                                            {{$retiro->estadoshipro->nombre}}
                                        </label>
                                    </td>
                                    <td>{{$retiro->servicioShipro}}</td>
                                    <td>{{$retiro->precio}}</td>
                                    <td>{{$retiro->peso}} kg</td>
                                    <td>
                                        <a href="{{route('guideadm', $retiro->id)}}"> 
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Ver guia Shipro"></span>
                              </a>
                                        <span href="" data-toggle="modal" data-target="#modalestado{{$retiro->id}}" style="cursor:pointer"> 
                          <span class="glyphicon glyphicon-transfer" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Editar estado Shipro"></span>
                                        </span>
                                        <span href="" data-toggle="modal" data-target="#modalemail{{$retiro->id}}" style="cursor:pointer"> 
                          <span class="glyphicon glyphicon-envelope" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Enviar email"></span>
                                        </span>
                                        @if ($retiro->ProveedorShipro == 'UPS')
                                        <a href="{{route('etiqueta', $retiro->id)}}" target="_blank"> 
                                    <span class="glyphicon glyphicon-picture" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver etiqueta UPS"></span>
                                </a> @elseif ($retiro->ProveedorShipro == 'FEDEX')
                                        <a href='{{ route('etiqueta_fedex', $retiro->id)}}'> 
                                    <span class="glyphicon glyphicon-picture" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver etiqueta FEDEX"></span>
                              </a> @endif {{-- <a href="{{route('voucher', $retiro->id)}}"
                                            target="_blank"> 
                                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Ver voucher"></span>
                                </a> --}}
                                    </td>
                                </tr>
                                <!-- Modal -->
                                {!!Form::open(['route'=>'sendmail', 'method'=>'POST'])!!}
                                <div class="modal fade" id="modalemail{{$retiro->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Enviar correo electronico a: @isset($retiro->comprador->apellido_nombre)
                                                    {{$retiro->comprador->apellido_nombre}} ({!!$retiro->comprador->email!!})
                                                    @endisset
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                {!!Form::hidden('idretiro',$retiro->id,['class'=>'', 'placeholder'=>'Empresa'])!!} {!!Form::textarea('mensaje', null, ['class'=>'modal_mail',
                                                'placeholder'=>'Mensaje', 'rows' => 2, 'cols' => 40])!!}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!!Form::close()!!}
                                <!-- Modal de estados -->
                                {!!Form::model($retiro, ['route'=>['retiros.update',$retiro->id], 'method'=>'PUT', 'files' => true])!!}
                                <div class="modal fade" id="modalestado{{$retiro->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel">Editar estado shipro del retiro con tracking {!!$retiro->trackingProveedor!!}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group col-md-12">
                                                    <div class="form-group col-md-3">
                                                        <div class="form-group">
                                                            <h5>
                                                                {!!Form::label('Estado actual:')!!}
                                                            </h5>
                                                            {!!Form::label($retiro->estadoshipro->nombre)!!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <div class="form-group">
                                                            <h5>
                                                                {!!Form::label('Cambiar a estado:')!!}
                                                            </h5> {!! Form::select('estado_id', $estados, null, ['class'
                                                            => 'input-large', 'placeholder' => 'Seleccione']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-5" style="text-align: center;">
                                                        <div class="form-group">
                                                            <br><br>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {!!Form::close()!!} @endforeach
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li v-if="pagination.current_page > 1">
                                    <a href="#" @click.prevent="changePage(pagination.current_page - 1)">
                                        <span>Atras</span>
                                    </a>
                                </li>
                                <li v-for="page in pagesNumber" v-bind:class="[ page == isActived ? 'active' : '']">
                                    <a href="" @click.prevent="changePage(page)">
                                        @{{ page }}
                                    </a>
                                </li>
                                <li v-if="pagination.current_page < pagination.last_page">
                                    <a href="#" @click.prevent="changePage(pagination.current_page + 1)">
                                        <span>Siguiente</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection
<script>
    $('.datepicker').datepicker();
</script>
{{-- <script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/toastr.js')}}"></script>
<script src="{{asset('js/vue.js')}}"></script>
<script src="{{asset('js/axios.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script> --}}
@section('js')
@endsection