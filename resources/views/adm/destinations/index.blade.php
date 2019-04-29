@extends('adm.layouts.admin')

@section('title', 'Shipro Internacional')

@section('content')
{{-- <link rel="stylesheet" href="{{asset('web/assets/css/home.css')}}"> --}}
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Listado de destinos</h3>
                </div>
                <a href="{{ route("destinations.create") }}">
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
                    <h2>Destinos</h2>
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
                            <th></th>
                          <th>Pais</th>
                          <th>Codigo IATA</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($destinations as $pais)
                            <tr>
                                <td></td>
                                <td class="center">{{ $pais->pais }}</td>
                                <td class="center">{{ $pais->iata_pais }}</td>
                                <td>
                                    <a href="{{ route('destinations.edit',$pais->id)}}">
                                    <button class="btn btn-success btn-xs">
                                        <i class="fas fa-pen-square" aria-hidden="true"></i>
                                            
                                        </button>
                                    </a>
                                   {{--  <a href="{{ route('destinations.destroy',$destination->id)}}">
                                        <i class="fas fa-trash-alt"> Eliminar</i>
                                    </a> --}}
                                    <a href="{{ route('destinations.destroydes',$pais->id)}}">
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