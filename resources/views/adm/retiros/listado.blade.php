@extends('adm.layouts.admin') 
@section('title', 'Shipro Internacional') 
@section('content')
<div class="right_col" role="main">
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
            <div id="retiro" class="row">
                    <div class="col-xs-12">
                            <h1 class="page-header">CRUD Laravel y Vuejs</h1>
                        </div>
                        <div class="col-sm-12">
                            {{-- <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#create">
                                Nueva tarea
                            </a> --}}
                            <table class="table table-hover table-striped">
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
                                        <th colspan="2">
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="retiro in retiros">
                                        <td width="10px">@{{ retiro.fecha_hora }}</td>
                                        <td>@{{ retiro.comprador.apellido_nombre }}</td>
                                        <td>@{{ retiro.ProveedorShipro }}</td>
                                        <td>@{{ retiro.trackingProveedor }}</td>
                                        <td>@{{ retiro.estado }}</td>
                                        <td>@{{ retiro.estadoshipro.nombre }}</td>
                                        <td>@{{ retiro.servicio.descripcion }}</td>
                                        <td>$ @{{ retiro.precio }}</td>
                                        <td>@{{ retiro.peso }} kg</td>
                                        <td width="10px">
                                            <a href="#" v-on:click.prevent="editKeep(keep)" class="btn btn-warning btn-sm">Editar</a>
                                        </td>
                                        <td width="10px">
                                            <a href="#" v-on:click.prevent="deleteKeep(keep)" class="btn btn-danger btn-sm">Eliminar</a>
                                        </td>
                                    </tr>
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
                           {{--  @include('create')
                            @include('edit') --}}
                        </div>
                        <div class="col-sm-5">
                                <pre>@{{ $data }}</pre>
                        </div>
                    </div>
    </div>

<!-- /page content -->
@endsection
@section('js')
<script src="{{asset('js/adm/retiros.js')}}"></script>
@endsection