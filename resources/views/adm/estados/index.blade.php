@extends('adm.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
{{-- <link rel="stylesheet" href="{{asset('web/assets/css/home.css')}}"> --}}
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Listado de estados</h3>
                </div>
                <a href="{{ route("estados.create") }}">
                    <button class="btn btn-primary right" name="action" type="submit">
                        Nuevo
                    </button>
                </a>
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
                    <h2>Estados</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                    {{--   Shipro Internacional --}}
                    </p>
                    
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Nombre de estado</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($estados as $estado)
                            <tr>
                                <td class="center">{{$estado->nombre}}</td>
                                <td>
                                    <a href="{{ route('estados.edit',$estado->id)}}">
                                    <button class="btn btn-success btn-xs">
                                        <i class="fas fa-pen-square" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('estado.eliminar',$estado->id)}}">
                                        <button class="btn btn-danger btn-xs" onclick="return confirm('¿Realmente deseas borrar el elemento?')" type="submit">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </a>
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
@endsection