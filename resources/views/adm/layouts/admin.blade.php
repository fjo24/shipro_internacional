<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('img/logo_shipro.png')}}" type="image/ico" />

    <title>
        @yield('title')
    </title>
    <!-- Bootstrap -->
    <link href="{{asset('gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('gentelella-master/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('gentelella-master/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('gentelella-master/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    {{-- iconos --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- bootstrap-progressbar -->
    <link href="{{asset('gentelella-master/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('gentelella-master/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

    <!-- bootstrap-datepicker -->
    <link href="{{asset('plugins/datepicker/datepicker.css')}}" rel="stylesheet">
    
    <!-- Datatables -->
    <link href="{{asset('gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('gentelella-master/build/css/custom.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/toastr.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><span>Shipro Internacional</span></a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                    <div class="logo">
                      <a class="brand-logo" href="{{route('home')}}" id="logo-container">
                          <img alt="" class="responsive-img" src="{{ asset('img/logo.png') }}"/>
                      </a>
                  </div>
                    <br>
                      <br>
                      <br>
                      <br>
                      <br>
                <h2 class="text-center">Menu</h2>
                <ul class="nav side-menu">
                <!--  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="index.html">Dashboard</a></li>
                      <li><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                    </ul>
                  </li>-->
                  <li><a href="{{ route('ordenes') }}"><i class="fa fa-truck" aria-hidden="true"></i>    Ordenes</a>
                  </li>
                  <li><a><i class="glyphicon glyphicon-credit-card" aria-hidden="true"></i>   Tipos de documentos</a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('documents.index') }}">Lista</a></li>
                      <li><a href="{{ route('documents.create') }}">Nuevo</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fas fa-clipboard-list"></i>    Estados shipro</a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('estados.index') }}">Listado</a></li>
                      <li><a href="{{ route('estados.create') }}">Nuevo</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fas fa-plane-arrival" aria-hidden="true"></i>  Paises</a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('destinations.index') }}">Lista</a></li>
                      {{-- <li><a href="{{ route('excel_destinations') }}">Importar desde excel</a></li> --}}
                    </ul>
                  </li>
                  <li><a><i class="fas fa-plane-arrival" aria-hidden="true"></i>  Provincias</a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('provincias.index') }}">Lista</a></li>
                      <li><a href="{{ route('excel_provincias') }}">Importar desde excel</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fas fa-map-marked-alt" aria-hidden="true"></i> Cordones de CP</a>
                    <ul class="nav child_menu">
                      <li><a href="{{ route('cpcordones.index') }}">Lista</a></li>
                      <li><a href="{{ route('cpcordones.create') }}">Nuevo</a></li>
                    </ul>
                  </li>
                  <li><a href="{{ route('home') }}"><i class="glyphicon glyphicon-user" aria-hidden="true"></i>     Zona usuarios</a>
                  </li>
                  {{-- <li><a href="{{ route('orders.index') }}"><i class="fa fa-truck"></i>Enviados</a>
                  </li>
                  <li><a href="{{ route('orders.store') }}"><i class="fa fa-shopping-cart"></i>Comprar</a>
                  </li> --}}
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="" alt="">{{ Auth::user()->name }}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </div>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
        @yield('content')
        <!-- footer content -->
        <footer>
            <div class="pull-right">
              Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
          </footer>
          <!-- /footer content -->
        </div>
      </div>
  
      <script src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
      </script>
      <!-- jQuery -->
      <script src="{{asset('gentelella-master/vendors/jquery/dist/jquery.min.js')}}"></script>
      <!-- Bootstrap -->
      <script src="{{asset('gentelella-master/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
      <!-- FastClick -->
      <script src="{{asset('gentelella-master/vendors/fastclick/lib/fastclick.js')}}"></script>
      <!-- NProgress -->
      <script src="{{asset('gentelella-master/vendors/nprogress/nprogress.js')}}"></script>
      <!-- Chart.js -->
      <script src="{{asset('gentelella-master/vendors/Chart.js/dist/Chart.min.js')}}"></script>
      <!-- gauge.js -->
      <script src="{{asset('gentelella-master/vendors/gauge.js/dist/gauge.min.js')}}"></script>
      <!-- bootstrap-progressbar -->
      <script src="{{asset('gentelella-master/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
      <!-- iCheck -->
      <script src="{{asset('gentelella-master/vendors/iCheck/icheck.min.js')}}"></script>
      

      <!-- blockui -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>

      <!-- Skycons -->
      <script src="{{asset('gentelella-master/vendors/skycons/skycons.js')}}"></script>
      <!-- Flot -->
      <script src="{{asset('gentelella-master/vendors/Flot/jquery.flot.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/Flot/jquery.flot.pie.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/Flot/jquery.flot.time.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/Flot/jquery.flot.stack.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/Flot/jquery.flot.resize.js')}}"></script>
      <!-- Flot plugins -->
      <script src="{{asset('gentelella-master/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/flot.curvedlines/curvedLines.js')}}"></script>
      <!-- DateJS -->
      <script src="{{asset('gentelella-master/vendors/DateJS/build/date.js')}}"></script>
      <!-- JQVMap -->
      <script src="{{asset('gentelella-master/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
      <!-- bootstrap-daterangepicker -->
      <script src="{{asset('gentelella-master/vendors/moment/min/moment.min.js')}}"></script>
      <script src="{{asset('gentelella-master/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  
      <!-- bootstrap-datepicker -->
    <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>

    <!-- Datatables -->
    <script src="{{asset('gentelella-master/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('gentelella-master/vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/toastr.js')}}"></script>
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{asset('js/axios.js')}}"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="{{asset('gentelella-master/build/js/custom.min.js')}}"></script>
    @yield('js')
    </body>
  </html>
  